<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientModule;
use App\Models\ClientPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        // Mock data for client dashboard stats
        $stats = [
            'activeDomains' => 3,
            'activeHostingPlans' => 2,
            'activeVpsServers' => 1,
            'pendingInvoices' => 1,
        ];

        // Mock data for client services
        $services = [
            [
                'type' => 'domain',
                'name' => 'example.com',
                'status' => 'active',
                'expires' => now()->addMonths(9),
                'auto_renewal' => true,
            ],
            [
                'type' => 'domain',
                'name' => 'mywebsite.net',
                'status' => 'active',
                'expires' => now()->addMonths(6),
                'auto_renewal' => false,
            ],
            [
                'type' => 'domain',
                'name' => 'mybusiness.org',
                'status' => 'active',
                'expires' => now()->addMonths(11),
                'auto_renewal' => true,
            ],
            [
                'type' => 'hosting',
                'name' => 'Premium Hosting',
                'status' => 'active',
                'expires' => now()->addMonths(8),
                'auto_renewal' => true,
            ],
            [
                'type' => 'hosting',
                'name' => 'Basic Hosting',
                'status' => 'active',
                'expires' => now()->addMonths(2),
                'auto_renewal' => true,
            ],
            [
                'type' => 'vps',
                'name' => 'Standard VPS',
                'status' => 'active',
                'expires' => now()->addMonths(5),
                'auto_renewal' => true,
            ],
        ];

        // Mock data for recent invoices
        $recentInvoices = [
            [
                'number' => 'INV-2023-124',
                'date' => now()->subDays(7),
                'amount' => 89.97,
                'status' => 'paid',
                'currency' => 'USD',
            ],
            [
                'number' => 'INV-2023-118',
                'date' => now()->subDays(14),
                'amount' => 39.99,
                'status' => 'paid',
                'currency' => 'USD',
            ],
            [
                'number' => 'INV-2023-142',
                'date' => now()->subDays(2),
                'amount' => 12.99,
                'status' => 'pending',
                'currency' => 'USD',
            ],
        ];

        return view('client.dashboard', ['stats' => $stats, 'services' => $services, 'recentInvoices' => $recentInvoices]);
    }

    /**
     * Show the client domains page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function domains()
    {
        // Mock data for client domains
        $domains = [
            [
                'name' => 'example.com',
                'registration_date' => now()->subMonths(3),
                'expiry_date' => now()->addMonths(9),
                'status' => 'active',
                'auto_renewal' => true,
                'nameservers' => ['ns1.nmdigitalhub.com', 'ns2.nmdigitalhub.com'],
                'dns_records' => 12,
            ],
            [
                'name' => 'mywebsite.net',
                'registration_date' => now()->subMonths(6),
                'expiry_date' => now()->addMonths(6),
                'status' => 'active',
                'auto_renewal' => false,
                'nameservers' => ['ns1.nmdigitalhub.com', 'ns2.nmdigitalhub.com'],
                'dns_records' => 8,
            ],
            [
                'name' => 'mybusiness.org',
                'registration_date' => now()->subMonths(1),
                'expiry_date' => now()->addMonths(11),
                'status' => 'active',
                'auto_renewal' => true,
                'nameservers' => ['ns1.nmdigitalhub.com', 'ns2.nmdigitalhub.com'],
                'dns_records' => 5,
            ],
        ];

        return view('client.domains', ['domains' => $domains]);
    }

    /**
     * Show the client hosting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function hosting()
    {
        // Mock data for client hosting plans
        $hostingPlans = [
            [
                'name' => 'Premium Hosting',
                'server' => 'srv-nm-01.nmdigitalhub.com',
                'ip_address' => '123.45.67.89',
                'start_date' => now()->subMonths(4),
                'expiry_date' => now()->addMonths(8),
                'status' => 'active',
                'auto_renewal' => true,
                'disk_usage' => [
                    'used' => 6.2, // GB
                    'total' => 100, // GB
                ],
                'bandwidth_usage' => [
                    'used' => 45.7, // GB
                    'total' => 1000, // GB
                ],
                'domains' => ['example.com', 'mywebsite.net'],
            ],
            [
                'name' => 'Basic Hosting',
                'server' => 'srv-nm-03.nmdigitalhub.com',
                'ip_address' => '123.45.67.90',
                'start_date' => now()->subMonths(10),
                'expiry_date' => now()->addMonths(2),
                'status' => 'active',
                'auto_renewal' => true,
                'disk_usage' => [
                    'used' => 1.8, // GB
                    'total' => 50, // GB
                ],
                'bandwidth_usage' => [
                    'used' => 28.3, // GB
                    'total' => 500, // GB
                ],
                'domains' => ['mybusiness.org'],
            ],
        ];

        return view('client.hosting', ['hostingPlans' => $hostingPlans]);
    }

    /**
     * Show the client VPS page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function vps()
    {
        // Mock data for client VPS servers
        $vpsServers = [
            [
                'name' => 'Standard VPS',
                'hostname' => 'vps-client-001.nmdigitalhub.com',
                'ip_address' => '123.45.68.101',
                'start_date' => now()->subMonths(7),
                'expiry_date' => now()->addMonths(5),
                'status' => 'active',
                'auto_renewal' => true,
                'operating_system' => 'Ubuntu 22.04 LTS',
                'specs' => [
                    'cpu' => 4, // cores
                    'ram' => 8, // GB
                    'storage' => 100, // GB
                    'bandwidth' => 3, // TB
                ],
                'usage' => [
                    'cpu' => 28, // percentage
                    'ram' => 45, // percentage
                    'storage' => 37, // percentage
                    'bandwidth' => 18, // percentage
                ],
            ],
        ];

        return view('client.vps', ['vpsServers' => $vpsServers]);
    }

    /**
     * Show the client invoices page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoices()
    {
        // Mock data for client invoices
        $invoices = [
            [
                'number' => 'INV-2023-124',
                'date' => now()->subDays(7),
                'due_date' => now()->subDays(7),
                'amount' => 89.97,
                'status' => 'paid',
                'payment_method' => 'Credit Card',
                'items' => [
                    [
                        'description' => 'Domain Renewal - example.com',
                        'amount' => 12.99,
                    ],
                    [
                        'description' => 'Domain Renewal - mywebsite.net',
                        'amount' => 14.99,
                    ],
                    [
                        'description' => 'Premium Hosting - Monthly',
                        'amount' => 61.99,
                    ],
                ],
                'currency' => 'USD',
            ],
            [
                'number' => 'INV-2023-118',
                'date' => now()->subDays(14),
                'due_date' => now()->subDays(14),
                'amount' => 39.99,
                'status' => 'paid',
                'payment_method' => 'PayPal',
                'items' => [
                    [
                        'description' => 'Standard VPS - Monthly',
                        'amount' => 39.99,
                    ],
                ],
                'currency' => 'USD',
            ],
            [
                'number' => 'INV-2023-142',
                'date' => now()->subDays(2),
                'due_date' => now()->addDays(12),
                'amount' => 12.99,
                'status' => 'pending',
                'payment_method' => null,
                'items' => [
                    [
                        'description' => 'Domain Registration - mybusiness.org',
                        'amount' => 12.99,
                    ],
                ],
                'currency' => 'USD',
            ],
        ];

        return view('client.invoices', ['invoices' => $invoices]);
    }

    /**
     * Show the client payment methods page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentMethods()
    {
        // Mock data for client payment methods
        $paymentMethods = [
            [
                'type' => 'credit_card',
                'brand' => 'Visa',
                'last_four' => '4242',
                'expiry' => '05/25',
                'default' => true,
            ],
            [
                'type' => 'credit_card',
                'brand' => 'Mastercard',
                'last_four' => '8210',
                'expiry' => '11/24',
                'default' => false,
            ],
            [
                'type' => 'paypal',
                'email' => 'client@example.com',
                'default' => false,
            ],
        ];

        return view('client.payment-methods', ['paymentMethods' => $paymentMethods]);
    }

    /**
     * Show the client profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        // Use the authenticated user instead of mock data in a real application
        $user = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1 (555) 123-4567',
            'address' => [
                'street' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'United States',
            ],
            'company' => 'Example Corp',
            'vat_number' => 'US123456789',
            'created_at' => now()->subYears(1),
        ];

        return view('client.profile', ['user' => $user]);
    }

    /**
     * Show the client settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        // Mock data for client settings
        $settings = [
            'notification_preferences' => [
                'email_invoice' => true,
                'email_domain_expiry' => true,
                'email_hosting_expiry' => true,
                'email_vps_expiry' => true,
                'email_promotions' => false,
            ],
            'currency' => 'USD',
            'language' => app()->getLocale(),
            'timezone' => 'America/New_York',
        ];

        // Available currencies for selection
        $currencies = [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'NIS' => 'Israeli Shekel',
        ];

        // Available timezones for selection (simplified list)
        $timezones = [
            'America/New_York' => 'Eastern Time (US & Canada)',
            'America/Chicago' => 'Central Time (US & Canada)',
            'America/Denver' => 'Mountain Time (US & Canada)',
            'America/Los_Angeles' => 'Pacific Time (US & Canada)',
            'Asia/Jerusalem' => 'Jerusalem',
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
        ];

        return view('client.settings', ['settings' => $settings, 'currencies' => $currencies, 'timezones' => $timezones]);
    }

    /**
     * Toggle auto-renewal for a service.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleAutoRenewal(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|in:domain,hosting,vps',
            'service_id' => 'required',
            'auto_renewal' => 'required|boolean',
        ]);

        // In a real application, you would update the auto-renewal status in the database
        $success = true; // Mock success response

        return response()->json([
            'success' => $success,
            'message' => $success
                ? 'Auto-renewal setting updated successfully.'
                : 'Failed to update auto-renewal setting.',
        ]);
    }

    /**
     * Update payment currency preference.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCurrency(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|in:USD,EUR,NIS',
        ]);

        // In a real application, you would update the user's currency preference in the database

        return redirect()->back()->with('success', 'Currency preference updated successfully.');
    }

    /**
     * Show a dynamic client panel page.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPage($slug)
    {
        // Find the page
        $page = ClientPage::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Check if user has access to this page
        if (! $page->isVisibleToUser(Auth::user())) {
            abort(403, 'You do not have permission to view this page.');
        }

        // Get the associated module if any
        $module = $page->module;

        // Get the layout view based on page layout or default
        $layout = $page->layout ?: 'default';

        return view("client.pages.{$layout}", ['page' => $page, 'module' => $module]);
    }

    /**
     * Show installed client modules (for testing).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showModules()
    {
        // Get all enabled client modules
        $modules = ClientModule::where('enabled', true)
            ->orderBy('position')
            ->get();

        // Get pages that show in menu
        $menuPages = ClientPage::where('show_in_menu', true)
            ->where('status', 'published')
            ->orderBy('menu_position')
            ->get();

        return view('client.modules', ['modules' => $modules, 'menuPages' => $menuPages]);
    }

    /**
     * Show the client statistics page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function statistics()
    {
        // Mock data for statistics
        $stats = [
            'domains' => [
                'total' => 3,
                'active' => 3,
                'expiring_soon' => 1,
                'traffic' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [1250, 1980, 1680, 2190, 2340, 2900],
                ],
            ],
            'hosting' => [
                'total' => 2,
                'disk_usage' => [
                    'used' => 8,
                    'total' => 150,
                ],
                'bandwidth_usage' => [
                    'used' => 74,
                    'total' => 1500,
                ],
                'uptime' => 99.98,
            ],
            'vps' => [
                'total' => 1,
                'cpu_usage' => [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [25, 38, 42, 35, 45, 25, 30],
                ],
                'ram_usage' => [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [40, 45, 50, 42, 65, 55, 45],
                ],
            ],
        ];

        return view('client.statistics', ['stats' => $stats]);
    }
}
