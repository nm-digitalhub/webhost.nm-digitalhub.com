<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'title' => 'לוח בקרה',
        'header' => 'לוח בקרה',
        'stats' => [
            'active_users' => 'משתמשים פעילים',
            'view_all_users' => 'צפה בכל המשתמשים',
            'active_services' => 'שירותים פעילים',
            'view_all_services' => 'צפה בכל השירותים',
            'total_revenue' => 'הכנסות כולל',
            'view_revenue_reports' => 'צפה בדוחות הכנסות',
            'open_tickets' => 'קריאות פתוחות',
            'view_open_tickets' => 'צפה בקריאות פתוחות',
        ],
        'recent_customers' => [
            'title' => 'לקוחות אחרונים',
            'none' => 'לא נמצאו לקוחות אחרונים.',
            'view_all' => 'הצג את כל המשתמשים',
        ],
        'recent_invoices' => [
            'title' => 'חשבוניות אחרונות',
            'invoice_number' => 'חשבונית #:number',
            'status' => [
                'paid' => 'שולם',
                'pending' => 'ממתין לתשלום',
                'cancelled' => 'בוטל',
                // Add other statuses if needed
            ],
            'none' => 'לא נמצאו חשבוניות אחרונות.',
            'view_all' => 'הצג את כל החשבוניות',
        ],
        'quick_actions' => [
            'title' => 'פעולות מהירות',
            'add_user' => [
                'title' => 'הוספת משתמש חדש',
                'description' => 'צור חשבון משתמש חדש',
            ],
            'add_service' => [
                'title' => 'הוספת שירות חדש',
                'description' => 'צור שירות חדש ללקוח',
            ],
            'create_invoice' => [
                'title' => 'יצירת חשבונית',
                'description' => 'הפק חשבונית חדשה ללקוח',
            ],
        ],
        'system_status' => [
            'title' => 'מצב מערכת',
            'services_by_category' => 'שירותים פעילים לפי קטגוריה',
            'categories' => [
                'hosting' => 'אחסון אתרים',
                'domains' => 'דומיינים',
                'vps' => 'שרתים וירטואליים',
                'ssl' => 'תעודות SSL',
            ],
            'active_count' => ':count פעילים',
            'expiring_soon' => 'שירותים המסתיימים בקרוב',
            'expiring_types' => [
                'domains' => 'דומיינים',
                'hosting' => 'חבילות אחסון',
                'vps' => 'שרתים וירטואליים',
                // Add other types if needed
            ],
            'expiring_message' => '{1} פריט :count פוקע בתוך :days ימים|[2,10] :count פריטים פוקעים בתוך :days ימים|[11,*] :count פריטים פוקעים בתוך :days ימים', // Adjusted pluralization for Hebrew
            'none_expiring' => 'אין שירותים שמסתיימים בקרוב.',
        ],
        'actions' => [
            'view' => 'צפה',
        ],
        'unknown_user' => 'משתמש לא ידוע',
    ],
    // Add other admin sections here...
];
