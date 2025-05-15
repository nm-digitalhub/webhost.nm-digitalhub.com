<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch the application's locale
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        // Validate that locale is either 'en' or 'he'
        if (in_array($locale, ['en', 'he'])) {
            // Store locale in session
            session()->put('locale', $locale);
        }

        // Redirect back to previous page
        return redirect()->back();
    }
}
