<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
// Compare this snippet from app/Http/Controllers/LanguageController.php:
