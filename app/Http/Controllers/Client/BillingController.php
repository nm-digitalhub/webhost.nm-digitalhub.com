<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
