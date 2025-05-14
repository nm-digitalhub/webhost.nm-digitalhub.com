<?php

namespace App\Services\Mail;

use App\Models\MailSetting;
use Google\Client as GoogleClient;
use Google\Service\Gmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GoogleOAuthService
{
    protected GoogleClient $client;

    protected ?MailSetting $settings;

    public function __construct()
    {
        $this->client = new GoogleClient;
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        $this->client->setIncludeGrantedScopes(true);
        $this->client->addScope(Gmail::GMAIL_SEND);
        $this->client->setRedirectUri(config('app.url').'/oauth/google/callback');

        $this->settings = MailSetting::getActiveSettings();
    }

    public function setupClient(): self
    {
        if (! $this->settings || ! $this->settings->oauth_mode_enabled) {
            return $this;
        }

        $jsonPath = $this->getJsonPath();

        if ($jsonPath && File::exists($jsonPath)) {
            try {
                $this->client->setAuthConfig($jsonPath);
            } catch (\Exception $e) {
                Log::error('Failed to load Google OAuth credentials from JSON: '.$e->getMessage());

                return $this;
            }
        } elseif (! empty($this->settings->google_client_id) && ! empty($this->settings->google_client_secret)) {
            $this->client->setClientId($this->settings->google_client_id);
            $this->client->setClientSecret($this->settings->google_client_secret);
            if (! empty($this->settings->google_redirect_uri)) {
                $this->client->setRedirectUri($this->settings->google_redirect_uri);
            }
        }

        return $this;
    }

    public function getAccessToken(): ?string
    {
        $token = $this->settings?->getValidAccessToken();

        // Refresh if expired and we have a refresh token
        if (! $token && $this->settings?->google_refresh_token) {
            try {
                $this->setupClient();
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->settings->google_refresh_token);
                if (isset($newToken['access_token'])) {
                    $this->storeTokenData($newToken);

                    return $newToken['access_token'];
                }
            } catch (\Exception $e) {
                Log::error('Failed to refresh Google OAuth token: '.$e->getMessage());
            }
        }

        return $token;
    }

    public function storeTokenData(array $tokenData): void
    {
        $this->settings?->storeGoogleOAuthToken($tokenData);
    }

    public function getAuthUrl(): string
    {
        $this->setupClient();

        return $this->client->createAuthUrl();
    }

    public function fetchAccessTokenWithAuthCode(string $code): array
    {
        try {
            $this->setupClient();

            return $this->client->fetchAccessTokenWithAuthCode($code);
        } catch (\Exception $e) {
            Log::error('Failed to fetch token with code: '.$e->getMessage());

            return [];
        }
    }

    public function applyToMailer(): void
    {
        if (! $this->settings || ! $this->settings->oauth_mode_enabled) {
            return;
        }

        $this->setupClient();
        $accessToken = $this->getAccessToken();

        if (! $accessToken) {
            Log::warning('No valid Google OAuth token found');

            return;
        }

        Config::set('mail.mailers.smtp.auth_mode', 'XOAUTH2');
        Config::set('mail.mailers.smtp.oauth_token', $accessToken);

        Config::set('mail.mailers.smtp.host', Config::get('mail.mailers.smtp.host', 'smtp.gmail.com'));
        Config::set('mail.mailers.smtp.port', Config::get('mail.mailers.smtp.port', 587));
        Config::set('mail.mailers.smtp.encryption', Config::get('mail.mailers.smtp.encryption', 'tls'));

        if ($this->settings->username) {
            Config::set('mail.mailers.smtp.username', $this->settings->username);
        }

        Log::info('Google OAuth SMTP settings applied successfully.');
    }

    public function isConfigured(): bool
    {
        $this->setupClient();

        return ! empty($this->client->getClientId()) && ! empty($this->client->getClientSecret());
    }

    public function hasValidToken(): bool
    {
        return $this->getAccessToken() !== null;
    }

    protected function getJsonPath(): ?string
    {
        if (! empty($this->settings->google_json_path) && File::exists($this->settings->google_json_path)) {
            return $this->settings->google_json_path;
        }

        $configPath = config('mail.google_oauth_json_path');
        if ($configPath && File::exists($configPath)) {
            return $configPath;
        }

        return null;
    }
}
