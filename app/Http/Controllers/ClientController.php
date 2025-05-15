<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * יצירת בקר חדש
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * הצגת דשבורד למשתמש
     */
    public function dashboard()
    {
        // Mock data for dashboard stats
        $stats = [
            'activeDomains' => 5,
            'activeHostingPlans' => 2,
            'activeVpsServers' => 1,
            'pendingInvoices' => 3,
        ];

        // Mock data for services
        $services = [];

        // Domains
        $services[] = [
            'name' => 'example.com',
            'type' => 'domain',
            'status' => 'active',
            'expires' => Carbon::now()->addMonths(10),
            'auto_renewal' => true,
        ];

        $services[] = [
            'name' => 'mywebsite.com',
            'type' => 'domain',
            'status' => 'active',
            'expires' => Carbon::now()->addMonths(8),
            'auto_renewal' => true,
        ];

        // Hosting
        $services[] = [
            'name' => 'Basic Hosting Plan',
            'type' => 'hosting',
            'status' => 'active',
            'expires' => Carbon::now()->addMonths(3),
            'auto_renewal' => true,
        ];

        // VPS
        $services[] = [
            'name' => 'Cloud VPS - 4GB RAM',
            'type' => 'vps',
            'status' => 'active',
            'expires' => Carbon::now()->addMonths(5),
            'auto_renewal' => true,
        ];

        // Mock data for recent invoices
        $recentInvoices = [];

        $recentInvoices[] = [
            'number' => 'INV-2023-001',
            'date' => Carbon::now()->subDays(5),
            'amount' => 120.00,
            'currency' => '$',
            'status' => 'paid',
        ];

        $recentInvoices[] = [
            'number' => 'INV-2023-002',
            'date' => Carbon::now()->subDays(3),
            'amount' => 45.00,
            'currency' => '$',
            'status' => 'pending',
        ];

        return view('client.dashboard', ['stats' => $stats, 'services' => $services, 'recentInvoices' => $recentInvoices]);
    }

    /**
     * דף דומיינים
     */
    public function domains()
    {
        return view('client.domains');
    }

    /**
     * דף אחסון
     */
    public function hosting()
    {
        return view('client.hosting');
    }

    /**
     * דף VPS
     */
    public function vps()
    {
        return view('client.vps');
    }

    /**
     * דף חשבוניות
     */
    public function invoices()
    {
        return view('client.invoices');
    }

    /**
     * דף פרופיל משתמש
     */
    public function profile()
    {
        return view('client.profile');
    }

    /**
     * דף אמצעי תשלום
     */
    public function paymentMethods()
    {
        return view('client.payment-methods');
    }

    /**
     * דף הגדרות משתמש
     */
    public function settings()
    {
        return view('client.settings');
    }

    /**
     * עדכון הגדרת חידוש אוטומטי
     */
    public function toggleAutoRenewal(Request $request)
    {
        // Validate request data
        $request->validate([
            'service_type' => 'required|string|in:domain,hosting,vps',
            'service_id' => 'required|numeric',
            'auto_renewal' => 'required|boolean',
        ]);

        // In a real application, this would update the database
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'Auto-renewal setting updated successfully.',
        ]);
    }

    /**
     * הצגת מודולים של הלקוח
     */
    public function showModules()
    {
        return view('client.modules');
    }

    /**
     * הצגת מסך סטטיסטיקה
     */
    public function statistics()
    {
        return view('client.statistics');
    }

    /**
     * הצגת דף מותאם
     */
    public function showPage($slug)
    {
        // In a real application, fetch the page from the database
        // For now, just render a generic page view
        return view('client.pages.show', ['slug' => $slug]);
    }

    /**
     * נתונים לדוגמה לדומיינים (גרסה ישנה)
     */
    private function getSampleDomains()
    {
        return collect([
            (object) [
                'name' => 'example.co.il',
                'renewal_date' => Carbon::createFromDate(2023, 10, 15),
                'status' => 'פעיל',
            ],
            (object) [
                'name' => 'mysite.co.il',
                'renewal_date' => Carbon::createFromDate(2023, 12, 2),
                'status' => 'פעיל',
            ],
        ]);
    }

    /**
     * נתונים לדוגמה לחשבוניות (גרסה ישנה)
     */
    private function getSampleInvoices()
    {
        return collect([
            (object) [
                'number' => '1234',
                'date' => Carbon::createFromDate(2023, 6, 1),
                'description' => 'חידוש אחסון',
                'amount' => 149.00,
                'status' => 'pending',
            ],
            (object) [
                'number' => '1233',
                'date' => Carbon::createFromDate(2023, 5, 15),
                'description' => 'חידוש דומיין',
                'amount' => 59.00,
                'status' => 'paid',
            ],
        ]);
    }
}
