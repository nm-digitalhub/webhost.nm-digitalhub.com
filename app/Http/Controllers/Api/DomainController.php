<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Check domain availability
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:63',
        ]);

        $domain = $request->input('name');

        // Sanitize domain name
        $domain = strtolower(trim((string) $domain));

        // Add .com if no TLD is specified
        if (! str_contains($domain, '.')) {
            $domain .= '.com';
        }

        // Simulate domain check (in a real app this would check with a domain registrar API)
        $available = random_int(0, 1) > 0.2; // 80% chance domain is available for this demo

        $price = 12.99;
        if (str_ends_with($domain, '.io')) {
            $price = 39.99;
        } elseif (str_ends_with($domain, '.co')) {
            $price = 24.99;
        } elseif (str_ends_with($domain, '.net')) {
            $price = 14.99;
        }

        $response = [
            'domain' => $domain,
            'available' => $available,
            'price' => $price,
            'suggestions' => $this->generateSuggestions($domain),
        ];

        return response()->json($response);
    }

    /**
     * Generate domain suggestions
     *
     * @return array
     */
    private function generateSuggestions(string $domain)
    {
        // Extract domain name without TLD
        $parts = explode('.', $domain);
        $name = $parts[0];

        // Generate suggestions with different TLDs and prefixes/suffixes
        $suggestions = [];

        $tlds = ['.com', '.net', '.org', '.io', '.co'];
        $prefixes = ['get', 'my', 'the', 'try'];
        $suffixes = ['app', 'hub', 'site', 'online'];

        // Add TLD variations
        foreach ($tlds as $tld) {
            if (! str_ends_with($domain, $tld)) {
                $suggestion = $name.$tld;
                $price = 12.99;

                if ($tld === '.io') {
                    $price = 39.99;
                } elseif ($tld === '.co') {
                    $price = 24.99;
                } elseif ($tld === '.net') {
                    $price = 14.99;
                }

                $suggestions[] = [
                    'domain' => $suggestion,
                    'available' => random_int(0, 1) > 0.3, // 70% chance it's available
                    'price' => $price,
                ];
            }
        }

        // Add prefix variations (with .com)
        foreach ($prefixes as $prefix) {
            $suggestion = $prefix.$name.'.com';
            $suggestions[] = [
                'domain' => $suggestion,
                'available' => random_int(0, 1) > 0.2, // 80% chance it's available
                'price' => 12.99,
            ];
        }

        // Add suffix variations (with .com)
        foreach ($suffixes as $suffix) {
            $suggestion = $name.$suffix.'.com';
            $suggestions[] = [
                'domain' => $suggestion,
                'available' => random_int(0, 1) > 0.2, // 80% chance it's available
                'price' => 12.99,
            ];
        }

        // Shuffle and limit to 5 suggestions
        shuffle($suggestions);

        return array_slice($suggestions, 0, 5);
    }
}
