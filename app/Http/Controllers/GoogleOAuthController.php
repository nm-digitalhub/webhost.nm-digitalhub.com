<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Mail\GoogleOAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class GoogleOAuthController extends Controller
{
    /**
     * Redirect to the Google OAuth consent screen
     */
    public function redirect(Request $request)
    {
        $service = app(GoogleOAuthService::class)->setupClient();

        if (! $service->isConfigured()) {
            Log::error('Google OAuth is not properly configured');

            return Redirect::back()->with('error', 'Google OAuth is not properly configured.');
        }

        $authUrl = $service->getAuthUrl();

        return Redirect::away($authUrl);
    }

    /**
     * Handle the OAuth callback from Google
     */
    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (empty($code)) {
            Log::error('No authorization code received from Google');

            return Redirect::route('filament.admin.resources.mail-settings.index')
                ->with('error', 'Google OAuth authentication failed: No authorization code received.');
        }

        $service = app(GoogleOAuthService::class)->setupClient();
        $token = $service->fetchAccessTokenWithAuthCode($code);

        if (empty($token) || ! isset($token['access_token'])) {
            Log::error('Failed to exchange authorization code for token', $token);

            return Redirect::route('filament.admin.resources.mail-settings.index')
                ->with('error', 'Google OAuth authentication failed: Could not retrieve access token.');
        }

        // עדכון חשוב:
        $service->storeTokenData($token);

        Log::info('Google OAuth authentication successful');

        return Redirect::route('filament.admin.resources.mail-settings.index')
            ->with('success', 'החיבור לחשבון Gmail בוצע בהצלחה. תוכל כעת לשלוח מיילים דרך חשבונך.');
    }
}
