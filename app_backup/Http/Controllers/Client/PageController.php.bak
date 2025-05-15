<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a client page by slug
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, string $slug)
    {
        // Find the page by slug
        $page = ClientPage::where('slug', $slug)->first();

        // If page doesn't exist, return 404
        if (!$page) {
            abort(404);
        }

        // Check if the page is visible to the current user
        if (!$page->isVisibleToUser($request->user())) {
            abort(403, 'You do not have permission to view this page.');
        }

        // Get the module for navigation highlighting
        $activeModule = $page->module;

        // Determine which layout to use
        $layout = $page->layout ?: 'default';
        $viewPath = "client.pages.{$layout}";

        // Check if custom view exists, otherwise use default
        if (!view()->exists($viewPath)) {
            $viewPath = 'client.pages.default';
        }

        return view($viewPath, ['page' => $page, 'activeModule' => $activeModule]);
    }
}