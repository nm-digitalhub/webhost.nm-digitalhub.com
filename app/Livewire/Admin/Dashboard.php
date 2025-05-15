<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats;

    public $recentActivities;

    public function mount()
    {
        // Initialize stats with sample data
        // In production, replace with actual data from your database
        $this->stats = [
            'activeDomains' => 15,
            'activeHostingPlans' => 8,
            'activeVpsServers' => 5,
            'totalRevenue' => 12500.50,
            'pendingInvoices' => 3,
            'totalCustomers' => 42,
            'newOrders' => 7,
            'openTickets' => 5,
        ];

        // Sample recent activities
        $this->recentActivities = [
            [
                'type' => 'domain_registration',
                'domain' => 'example.com',
                'user' => 'דני ישראלי',
                'amount' => 15.99,
                'date' => Carbon::now()->subDays(1),
            ],
            [
                'type' => 'hosting_purchase',
                'plan' => 'Business Plus',
                'user' => 'רונית כהן',
                'amount' => 49.99,
                'date' => Carbon::now()->subDays(2),
            ],
            [
                'type' => 'vps_upgrade',
                'from' => 'VPS Basic',
                'to' => 'VPS Premium',
                'user' => 'יוסף לוי',
                'amount' => 25.00,
                'date' => Carbon::now()->subDays(3),
            ],
            [
                'type' => 'invoice_payment',
                'invoice' => 'INV-2023-1234',
                'user' => 'מיכל ברק',
                'amount' => 129.99,
                'date' => Carbon::now()->subDays(4),
            ],
            [
                'type' => 'ticket_open',
                'ticket' => 'TIK-2023-567',
                'user' => 'אורי אבני',
                'amount' => 0.00,
                'date' => Carbon::now()->subDays(5),
            ],
            [
                'type' => 'domain_renewal',
                'domain' => 'business-site.co.il',
                'user' => 'שירה כהן',
                'amount' => 75.00,
                'date' => Carbon::now()->subDays(6),
            ],
            [
                'type' => 'hosting_upgrade',
                'from' => 'Starter',
                'to' => 'Professional',
                'user' => 'יעקב לוי',
                'amount' => 45.00,
                'date' => Carbon::now()->subDays(7),
            ],
        ];
    }

    /**
     * Get real-time dashboard data in a production environment
     *
     * @return array
     */
    private function getDashboardData()
    {
        // In a production environment, you would retrieve this data from your database
        // This is a placeholder for the actual implementation

        return [
            'activeDomains' => 0, // Domains::where('status', 'active')->count(),
            'activeHostingPlans' => 0, // HostingPlan::where('status', 'active')->count(),
            'activeVpsServers' => 0, // VpsServer::where('status', 'active')->count(),
            'totalRevenue' => 0, // Invoice::where('status', 'paid')->sum('amount'),
            'pendingInvoices' => 0, // Invoice::where('status', 'pending')->count(),
            'totalCustomers' => 0, // User::where('role', 'client')->count(),
            'newOrders' => 0, // Order::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'openTickets' => 0, // Ticket::where('status', 'open')->count(),
        ];
    }

    /**
     * Get recent activities in a production environment
     *
     * @return array
     */
    private function getRecentActivities()
    {
        // In a production environment, you would retrieve this data from your database
        // This is a placeholder for the actual implementation

        // Example query:
        // return Activity::latest()->take(10)->get()->map(function($activity) {
        //     return [
        //         'type' => $activity->type,
        //         'domain' => $activity->domain,
        //         'plan' => $activity->plan,
        //         'invoice' => $activity->invoice,
        //         'from' => $activity->from,
        //         'to' => $activity->to,
        //         'user' => $activity->user->name,
        //         'amount' => $activity->amount,
        //         'date' => $activity->created_at
        //     ];
        // })->toArray();

        return [];
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('livewire.admin.layout');
    }
}
