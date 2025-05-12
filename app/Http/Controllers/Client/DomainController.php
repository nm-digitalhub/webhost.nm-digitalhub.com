<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainController extends Controller
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
     * Show DNS management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dnsManagement()
    {
        return view('client.dns-management');
    }

    /**
     * Show domain search page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function domainSearch()
    {
        return view('client.domain-search');
    }
}