<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MailSetting extends Model
{
    protected $fillable = [
        'driver',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'reply_to_address',
        'reply_to_name',
        'use_no_reply',
        'default_language',
        'signature',
        'is_active',
        'oauth_mode_enabled',
        'google_client_id',
        'google_client_secret',
        'google_redirect_uri',
        'google_json_path',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'use_no_reply' => 'boolean',
        'oauth_mode_enabled' => 'boolean',
        'google_token_expires_at' => 'datetime',
    ];

    public static function getActiveSettings()
    {
        return self::where('is_active', true)->first();
    }

    public function getPasswordAttribute($value)
    {
        if (! empty($value)) {
            return Crypt::decryptString($value);
        }

        return $value;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = empty($value)
            ? $value
            : Crypt::encryptString($value);
    }

    public function getGoogleClientSecretAttribute($value)
    {
        if (! empty($value)) {
            return Crypt::decryptString($value);
        }

        return $value;
    }

    public function setGoogleClientSecretAttribute($value)
    {
        $this->attributes['google_client_secret'] = empty($value)
            ? $value
            : Crypt::encryptString($value);
    }

    public function getValidAccessToken(): ?string
    {
        if ($this->google_token_expires_at && $this->google_token_expires_at->isFuture()) {
            return $this->google_access_token;
        }

        return null;
    }

    public function storeGoogleOAuthToken(array $tokenData): void
    {
        $this->update([
            'google_access_token' => $tokenData['access_token'],
            'google_refresh_token' => $tokenData['refresh_token'] ?? $this->google_refresh_token,
            'google_token_expires_at' => now()->addSeconds($tokenData['expires_in']),
        ]);
    }

    public function getConfig(): array
    {
        $config = [
            'driver' => $this->driver,
            'host' => $this->host,
            'port' => $this->port,
            'username' => $this->username,
            'password' => $this->password,
            'encryption' => $this->encryption,
            'from' => [
                'address' => $this->from_address ?? config('mail.from.address'),
                'name' => $this->from_name ?? config('mail.from.name'),
            ],
        ];

        if (! empty($this->reply_to_address)) {
            $config['reply_to'] = [
                'address' => $this->reply_to_address,
                'name' => $this->reply_to_name ?? $this->from_name,
            ];
        } elseif ($this->use_no_reply) {
            $config['reply_to'] = [
                'address' => 'noreply@'.parse_url((string) config('app.url'), PHP_URL_HOST),
                'name' => 'No Reply',
            ];
        }

        if ($this->oauth_mode_enabled) {
            $config['google_oauth'] = [
                'enabled' => true,
                'client_id' => $this->google_client_id,
                'client_secret' => $this->google_client_secret,
                'redirect_uri' => $this->google_redirect_uri,
                'json_path' => $this->google_json_path ?: config('mail.google_oauth_json_path'),
            ];
        }

        return $config;
    }
}
