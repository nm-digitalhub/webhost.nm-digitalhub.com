<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\Ticket;

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
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Get recent invoices
        $recentInvoices = Invoice::with('user')
                          ->orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();

        return view('admin.dashboard', ['userCount' => $userCount, 'activeServices' => $activeServices, 'totalRevenue' => $totalRevenue, 'pendingRevenue' => $pendingRevenue, 'openTickets' => $openTickets, 'recentCustomers' => $recentCustomers, 'recentInvoices' => $recentInvoices]);
    }
}
