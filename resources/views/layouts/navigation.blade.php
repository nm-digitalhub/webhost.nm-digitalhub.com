<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'description' => 'Welcome to the admin panel.',
        ];

        return view('admin.dashboard', $data);
    }

    public function domains()
    {
        return view('admin.domains');
    }

    public function hosting()
    {
        return view('admin.hosting');
    }

    public function vps()
    {
        return view('admin.vps');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function invoices()
    {
        return view('admin.invoices');
    }

    public function paymentGateways()
    {
        return view('admin.payment-gateways');
    }

    public function webhookLogs()
    {
        return view('admin.webhook-logs');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function translations()
    {
        return view('admin.translations');
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
