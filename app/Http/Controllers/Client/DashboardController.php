<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Ticket;

class DashboardController extends Controller
{
    /**
     * Display client dashboard with service summary
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Get user's active services
        $activeServices = Service::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        // Get recent invoices
        $recentInvoices = Invoice::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Get unpaid invoices
        $unpaidInvoices = Invoice::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        // Calculate total and upcoming payments
        $totalSpent = Invoice::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');

        $upcomingPayments = Invoice::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        // Get recent tickets
        $recentTickets = Ticket::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // Get system notifications
        $notifications = $user->notifications()->take(5)->get();

        return view('client.dashboard', ['activeServices' => $activeServices, 'recentInvoices' => $recentInvoices, 'unpaidInvoices' => $unpaidInvoices, 'totalSpent' => $totalSpent, 'upcomingPayments' => $upcomingPayments, 'recentTickets' => $recentTickets, 'notifications' => $notifications]);
    }
}
