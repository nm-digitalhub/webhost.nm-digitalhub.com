<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply auth middleware only to authenticated user routes
        $this->middleware('auth')->only(['dashboard', 'profile', 'settings']);
    }

    /**
     * Display the home page with featured domains
     */
    public function index(): View
    {
        try {
            $featuredDomains = [
                'example.com',
                'yourdomain.co.il',
                'digitalhub.co.il',
                'nmdigital.co.il',
                'tech-hub.co.il',
                'innovationhub.com',
                'business.co.il',
                'cloudserver.co.il',
                'web-solutions.co.il',
            ];

            // Get random 6 domains from the array
            $shuffledDomains = collect($featuredDomains)->shuffle()->take(6)->all();

            return view('home', ['shuffledDomains' => $shuffledDomains]);
        } catch (\Exception $e) {
            \Log::error('Home page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת העמוד. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Handle domain search
     */
    public function search(Request $request): RedirectResponse
    {
        try {
            // Add validation for domain name
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'regex:/^(?!-)(?!.*--)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z]{2,})+$/',
                ],
            ]);

            $domain = $validatedData['name'];

            // For now, just return to the home page with a success message in Hebrew
            return redirect()->route('home')->with('message', "חיפוש בוצע עבור דומיין: {$domain}");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('home')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Domain search error: '.$e->getMessage());

            return redirect()->route('home')->with('error', 'שגיאה בחיפוש הדומיין. אנא נסה שוב.');
        }
    }

    /**
     * Display domains page
     */
    public function domains(): View
    {
        try {
            return view('domains');
        } catch (\Exception $e) {
            \Log::error('Domains page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד הדומיינים. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Display hosting page
     */
    public function hosting(): View
    {
        try {
            return view('hosting');
        } catch (\Exception $e) {
            \Log::error('Hosting page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד האחסון. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Display VPS hosting page
     */
    public function vps(): View
    {
        try {
            return view('vps');
        } catch (\Exception $e) {
            \Log::error('VPS page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד ה-VPS. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Display cloud solutions page
     */
    public function cloud(): View
    {
        try {
            return view('cloud');
        } catch (\Exception $e) {
            \Log::error('Cloud page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד הענן. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request): RedirectResponse
    {
        try {
            // Validate the contact form submission
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            // Here you would typically process the contact form
            // For now, just return with success message
            return redirect()->route('home')->with('message', 'ההודעה נשלחה בהצלחה. נציג שלנו יצור עמך קשר בהקדם.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('home')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Contact form error: '.$e->getMessage());

            return redirect()->route('home')->with('error', 'שגיאה בשליחת הטופס. אנא נסה שוב.');
        }
    }

    /**
     * Show the user dashboard page (authenticated)
     */
    public function dashboard(): View
    {
        try {
            $user = Auth::user();

            return view('dashboard', ['user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Dashboard page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת הדשבורד. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Show the user profile page (authenticated)
     */
    public function profile(): View
    {
        try {
            $user = Auth::user();

            return view('profile', ['user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Profile page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד הפרופיל. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Show the settings page (authenticated)
     */
    public function settings(): View
    {
        try {
            $user = Auth::user();

            return view('settings', ['user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Settings page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד ההגדרות. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Display the terms page
     */
    public function terms(): View
    {
        try {
            return view('terms');
        } catch (\Exception $e) {
            \Log::error('Terms page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד התקנון. אנא נסה שוב מאוחר יותר.');
        }
    }

    /**
     * Display the privacy policy page
     */
    public function policy(): View
    {
        try {
            return view('policy');
        } catch (\Exception $e) {
            \Log::error('Policy page error: '.$e->getMessage());

            return view('home')->with('error', 'שגיאה בטעינת עמוד מדיניות הפרטיות. אנא נסה שוב מאוחר יותר.');
        }
    }
}
