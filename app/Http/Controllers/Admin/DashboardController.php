<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count total users
        $userCount = User::where('type', 'client')->count();

        // Count active services
        $activeServices = Service::where('status', 'active')->count();

        // Calculate revenue stats
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $pendingRevenue = Invoice::where('status', 'pending')->sum('amount');

        // Get open tickets count
        $openTickets = Ticket::where('status', 'open')->count();

        // Get recent customers
        $recentCustomers = User::where('type', 'client')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Get recent invoices
        $recentInvoices = Invoice::with('user')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', ['userCount' => $userCount, 'activeServices' => $activeServices, 'totalRevenue' => $totalRevenue, 'pendingRevenue' => $pendingRevenue, 'openTickets' => $openTickets, 'recentCustomers' => $recentCustomers, 'recentInvoices' => $recentInvoices]);
    }
}
