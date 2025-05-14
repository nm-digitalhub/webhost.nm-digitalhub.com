<?php

namespace App\Services\Mail;

use App\Models\MailTemplate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class MailTemplateManager
{
    /**
     * Render a mail template with the given data
     *
     * @param  MailTemplate|string  $template  The template model or template name
     * @param  mixed  $user  The user model or data object with attributes
     * @param  array  $additionalData  Additional data to merge
     * @param  string|null  $lang  Language code
     * @return array Array with subject and body keys
     */
    public static function render($template, $user = null, array $additionalData = [], ?string $lang = null): array
    {
        if (is_string($template)) {
            $template = MailTemplate::findTemplate($template, $lang);

            if (! $template) {
                Log::error("Mail template not found: $template");

                return [
                    'subject' => 'Notification',
                    'body' => 'No template found.',
                ];
            }
        }

        // Prepare data for the template
        $data = [];

        // Add user data if provided
        if ($user) {
            foreach (get_object_vars($user) as $key => $value) {
                if (! is_object($value) && ! is_array($value)) {
                    $data[$key] = $value;
                }
            }
        }

        // Add additional data
        $data = array_merge($data, $additionalData);

        // Ensure all required variables exist
        if ($template->variables) {
            foreach ($template->variables as $varName) {
                if (! isset($data[$varName])) {
                    $data[$varName] = "[$varName]";
                }
            }
        }

        // Render subject and body
        $subject = self::renderString($template->subject, $data);
        $body = self::renderString($template->body, $data);

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }

    /**
     * Render a template string with Blade syntax
     */
    public static function renderString(string $string, array $data = []): string
    {
        return Blade::render($string, $data);
    }

    /**
     * Preview a template with sample data
     */
    public static function preview(MailTemplate $template): array
    {
        $sampleData = [
            'name' => $template->lang === 'he' ? 'משתמש לדוגמה' : 'John Doe',
            'email' => 'example@'.parse_url((string) config('app.url'), PHP_URL_HOST),
            'password' => $template->lang === 'he' ? 'סיסמה_לדוגמה_123' : 'sample-password-123',
            'reset_url' => url('/reset-password?token=sample-token'),
            'login_url' => url('/login'),
            'verification_url' => url('/verify-email?token=sample-token'),
            'app_name' => config('app.name'),
            'date' => now()->format('Y-m-d H:i:s'),
            'action_url' => url('/dashboard'),
            'code' => '123456',
        ];

        // Add any variables defined in the template
        if ($template->variables) {
            foreach ($template->variables as $var) {
                if (! isset($sampleData[$var])) {
                    $sampleData[$var] = "[$var]";
                }
            }
        }

        return self::render($template, null, $sampleData);
    }
}
