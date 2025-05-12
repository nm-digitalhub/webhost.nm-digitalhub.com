<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a page by its slug.
     */
    public function show(string $slug, Request $request): ViewResponse|RedirectResponse
    {
        $language = App::getLocale();
        
        // Find the page by slug and language
        $page = Page::where('slug', $slug)
            ->where('language', $language)
            ->where('is_published', true)
            ->first();
        
        // If page not found, try to find it without language constraint
        if (!$page) {
            $page = Page::where('slug', $slug)
                ->where('is_published', true)
                ->first();
        }
        
        // If still not found, fall back to static views or show 404
        if (!$page) {
            if (View::exists("pages.{$slug}")) {
                return view("pages.{$slug}");
            }
            
            abort(404);
        }
        
        // Render the page based on its type and layout
        return $this->renderPageByType($page);
    }
    
    /**
     * Render a page based on its type and layout.
     *
     * @param  \App\Models\Page  $page
     */
    protected function renderPageByType(Page $page): ViewResponse
    {
        // Prepare general data available to all page types
        $data = [
            'page' => $page,
            'title' => $page->meta_title ?: $page->title,
            'metadata' => $page->metadata ?: [],
        ];
        
        // Check if we have a specialized template for this page type
        $typeTemplate = "pages.types.{$page->type}";
        
        if (View::exists($typeTemplate)) {
            return view($typeTemplate, $data);
        }
        
        // Check if we have a specialized template for this page layout
        $layoutTemplate = "pages.layouts.{$page->layout}";
        
        if (View::exists($layoutTemplate)) {
            return view($layoutTemplate, $data);
        }
        
        // Fall back to a generic page template
        return view('pages.show', $data);
    }
    
    /**
     * Display the home page.
     */
    public function home(Request $request): ViewResponse
    {
        $language = App::getLocale();
        
        // Try to find a home page in the database
        $page = Page::where('type', 'home')
            ->where('language', $language)
            ->where('is_published', true)
            ->first();
        
        // If not found, try without language constraint
        if (!$page) {
            $page = Page::where('type', 'home')
                ->where('is_published', true)
                ->first();
        }
        
        // If we found a home page in the CMS, render it
        if ($page) {
            return $this->renderPageByType($page);
        }
        
        // Fallback to the static home view
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
                'web-solutions.co.il'
            ];

            // Get random 6 domains from the array
            $shuffledDomains = collect($featuredDomains)->shuffle()->take(6)->all();

            return view('home', ['shuffledDomains' => $shuffledDomains]);
        } catch (\Exception $e) {
            \Log::error('Home page error: ' . $e->getMessage());
            return view('home')->with('error', 'שגיאה בטעינת העמוד. אנא נסה שוב מאוחר יותר.');
        }
    }
    
    /**
     * Display service pages (domains, hosting, vps, cloud).
     */
    public function servicePage(string $type, Request $request): ViewResponse
    {
        $validTypes = ['domains', 'hosting', 'vps', 'cloud'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }
        
        $language = App::getLocale();
        
        // Try to find a service page in the database
        $page = Page::where('type', $type)
            ->where('language', $language)
            ->where('is_published', true)
            ->first();
        
        // If not found, try without language constraint
        if (!$page) {
            $page = Page::where('type', $type)
                ->where('is_published', true)
                ->first();
        }
        
        // If we found a service page in the CMS, render it
        if ($page) {
            return $this->renderPageByType($page);
        }
        
        // Fallback to static view if it exists
        if (View::exists($type)) {
            try {
                return view($type);
            } catch (\Exception $e) {
                \Log::error("{$type} page error: " . $e->getMessage());
                return view('home')->with('error', "שגיאה בטעינת עמוד {$type}. אנא נסה שוב מאוחר יותר.");
            }
        }
        
        // If no view exists, show 404
        abort(404);
    }
    
    /**
     * Display terms page.
     */
    public function terms(Request $request): ViewResponse
    {
        $language = App::getLocale();
        
        // Try to find a terms page in the database
        $page = Page::where('type', 'legal')
            ->where('slug', 'terms')
            ->where('language', $language)
            ->where('is_published', true)
            ->first();
        
        // If not found, try without language constraint
        if (!$page) {
            $page = Page::where('type', 'legal')
                ->where('slug', 'terms')
                ->where('is_published', true)
                ->first();
        }
        
        if ($page) {
            $terms = $page->content;
            return view('terms', ['terms' => $terms]);
        }
        
        // Fallback to markdown file
        try {
            $terms = (string) file_get_contents(resource_path('markdown/terms.md'));
            return view('terms', ['terms' => $terms]);
        } catch (\Exception $e) {
            \Log::error('Terms page error: ' . $e->getMessage());
            return view('home')->with('error', 'שגיאה בטעינת עמוד התקנון. אנא נסה שוב מאוחר יותר.');
        }
    }
    
    /**
     * Display privacy policy page.
     */
    public function policy(Request $request): ViewResponse
    {
        $language = App::getLocale();
        
        // Try to find a policy page in the database
        $page = Page::where('type', 'legal')
            ->where('slug', 'policy')
            ->where('language', $language)
            ->where('is_published', true)
            ->first();
        
        // If not found, try without language constraint
        if (!$page) {
            $page = Page::where('type', 'legal')
                ->where('slug', 'policy')
                ->where('is_published', true)
                ->first();
        }
        
        if ($page) {
            $policy = $page->content;
            return view('policy', ['policy' => $policy]);
        }
        
        // Fallback to markdown file
        try {
            $policy = (string) file_get_contents(resource_path('markdown/policy.md'));
            return view('policy', ['policy' => $policy]);
        } catch (\Exception $e) {
            \Log::error('Policy page error: ' . $e->getMessage());
            return view('home')->with('error', 'שגיאה בטעינת עמוד מדיניות הפרטיות. אנא נסה שוב מאוחר יותר.');
        }
    }
}