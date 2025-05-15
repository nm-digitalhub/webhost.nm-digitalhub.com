<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\MailSetting;
use App\Services\Mail\GoogleOAuthService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // אל תריץ את הקוד אם מדובר בפקודת artisan
        if ($this->app->runningInConsole()) {
            return;
        }

        // הגדרת הכיוון RTL לשפה העברית
        if (app()->getLocale() === 'he') {
            app()->setLocale('he');
        }

        // Configure mail settings from database if available
        try {
            if (Schema::hasTable('mail_settings')) {
                $settings = MailSetting::where('is_active', true)->first();

                if ($settings) {
                    $config = $settings->getConfig();

                    Config::set('mail.default', $config['driver']);
                    Config::set('mail.from.address', $config['from']['address']);
                    Config::set('mail.from.name', $config['from']['name']);

                    if (isset($config['reply_to'])) {
                        Config::set('mail.reply_to.address', $config['reply_to']['address']);
                        Config::set('mail.reply_to.name', $config['reply_to']['name']);
                    }

                    if ($settings->default_language) {
                        Config::set('app.locale', $settings->default_language);
                    }

                    if ($config['driver'] === 'smtp') {
                        Config::set('mail.mailers.smtp.host', $config['host']);
                        Config::set('mail.mailers.smtp.port', $config['port']);
                        Config::set('mail.mailers.smtp.username', $config['username']);
                        Config::set('mail.mailers.smtp.password', $config['password']);
                        Config::set('mail.mailers.smtp.encryption', $config['encryption']);
                    }

                    if (isset($config['google_oauth']) && $config['google_oauth']['enabled'] && config('mail.google_oauth_mode', false)) {
                        app(GoogleOAuthService::class)->applyToMailer();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to load mail settings: ' . $e->getMessage());
        }
    }
}
