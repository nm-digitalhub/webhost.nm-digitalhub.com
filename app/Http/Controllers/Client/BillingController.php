<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    /**
     * Show subscriptions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function subscriptions()
    {
        return view('client.subscriptions');
    }
}
