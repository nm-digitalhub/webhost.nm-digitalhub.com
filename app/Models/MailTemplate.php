<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'variables',
        'layout',
        'lang',
        'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInLanguage($query, $lang)
    {
        return $query->where('lang', $lang);
    }

    public static function findTemplate(string $name, ?string $lang = null)
    {
        $lang ??= app()->getLocale();

        // Try to find a template with exact name and language
        $template = self::where('name', $name)
            ->where('lang', $lang)
            ->where('is_active', true)
            ->first();

        // If not found, try to find one with the name without language suffix
        if (! $template) {
            $template = self::where('name', $name)
                ->where('is_active', true)
                ->first();
        }

        // If still not found, try with English as fallback
        if (! $template && $lang !== 'en') {
            $template = self::where('name', $name)
                ->where('lang', 'en')
                ->where('is_active', true)
                ->first();
        }

        return $template;
    }
}
