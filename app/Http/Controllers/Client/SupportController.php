<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class SupportController extends Controller
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
     * Show knowledge base.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function knowledgeBase()
    {
        return view('client.knowledge-base');
    }

    /**
     * Show tickets.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tickets()
    {
        return view('client.tickets');
    }
}
