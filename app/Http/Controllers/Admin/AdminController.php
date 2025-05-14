<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        // Mock data for dashboard stats
        $stats = [
            'activeDomains' => 126,
            'activeHostingPlans' => 84,
            'activeVpsServers' => 47,
            'totalRevenue' => 12589.45,
            'pendingInvoices' => 18,
        ];

        // Mock data for recent activities
        $recentActivities = [
            [
                'type' => 'domain_registration',
                'domain' => 'example.com',
                'user' => 'John Doe',
                'amount' => 12.99,
                'date' => now()->subHours(2),
            ],
            [
                'type' => 'hosting_purchase',
                'plan' => 'Premium Hosting',
                'user' => 'Jane Smith',
                'amount' => 8.99,
                'date' => now()->subHours(5),
            ],
            [
                'type' => 'vps_upgrade',
                'from' => 'Basic VPS',
                'to' => 'Standard VPS',
                'user' => 'David Brown',
                'amount' => 20.00,
                'date' => now()->subHours(8),
            ],
            [
                'type' => 'payment_received',
                'invoice' => 'INV-2023-054',
                'user' => 'Sarah Johnson',
                'amount' => 149.99,
                'date' => now()->subHours(12),
            ],
            [
                'type' => 'domain_renewal',
                'domain' => 'mywebsite.com',
                'user' => 'Michael Wilson',
                'amount' => 14.99,
                'date' => now()->subHours(24),
            ],
        ];

        return view('admin.dashboard', ['stats' => $stats, 'recentActivities' => $recentActivities]);
    }

    /**
     * Show the domains management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function domains()
    {
        return view('admin.domains');
    }

    /**
     * Show the hosting plans management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function hosting()
    {
        return view('admin.hosting');
    }

    /**
     * Show the VPS solutions management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vps()
    {
        return view('admin.vps');
    }

    /**
     * Show the users management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users()
    {
        return view('admin.users');
    }

    /**
     * Show the invoices management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoices()
    {
        return view('admin.invoices');
    }

    /**
     * Show the payment gateways settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentGateways()
    {
        return view('admin.payment-gateways');
    }

    /**
     * Show the webhook logs page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function webhookLogs()
    {
        return view('admin.webhook-logs');
    }

    /**
     * Show the general settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Show the translations management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function translations()
    {
        return view('admin.translations');
    }

    /**
     * Show the admin profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('admin.profile');
    }
}
