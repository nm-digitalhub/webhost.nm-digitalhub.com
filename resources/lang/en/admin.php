<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'header' => 'Dashboard',
        'stats' => [
            'active_users' => 'Active Users',
            'view_all_users' => 'View all users',
            'active_services' => 'Active Services',
            'view_all_services' => 'View all services',
            'total_revenue' => 'Total Revenue',
            'view_revenue_reports' => 'View revenue reports',
            'open_tickets' => 'Open Tickets',
            'view_open_tickets' => 'View open tickets',
        ],
        'recent_customers' => [
            'title' => 'Recent Customers',
            'none' => 'No recent customers found.',
            'view_all' => 'View all users',
        ],
        'recent_invoices' => [
            'title' => 'Recent Invoices',
            'invoice_number' => 'Invoice #:number',
            'status' => [
                'paid' => 'Paid',
                'pending' => 'Pending',
                'cancelled' => 'Cancelled',
                // Add other statuses if needed
            ],
            'none' => 'No recent invoices found.',
            'view_all' => 'View all invoices',
        ],
        'quick_actions' => [
            'title' => 'Quick Actions',
            'add_user' => [
                'title' => 'Add New User',
                'description' => 'Create a new user account',
            ],
            'add_service' => [
                'title' => 'Add New Service',
                'description' => 'Create a new service for a client',
            ],
            'create_invoice' => [
                'title' => 'Create Invoice',
                'description' => 'Generate a new invoice for a client',
            ],
        ],
        'system_status' => [
            'title' => 'System Status',
            'services_by_category' => 'Active Services by Category',
            'categories' => [
                'hosting' => 'Web Hosting',
                'domains' => 'Domains',
                'vps' => 'VPS Servers',
                'ssl' => 'SSL Certificates',
            ],
            'active_count' => ':count Active',
            'expiring_soon' => 'Expiring Soon',
            'expiring_types' => [
                'domains' => 'Domains',
                'hosting' => 'Hosting Plans',
                'vps' => 'VPS Servers',
                // Add other types if needed
            ],
            'expiring_message' => '{1} :count item expiring within :days days|[2,*] :count items expiring within :days days',
            'none_expiring' => 'No services expiring soon.',
        ],
        'actions' => [
            'view' => 'View',
        ],
        'unknown_user' => 'Unknown User',
    ],
    // Add other admin sections here...
];
