<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Redirect::to('/admin');
    }

    public function domains()
    {
        return Redirect::to('/admin/domains');
    }

    public function hosting()
    {
        return Redirect::to('/admin/hosting');
    }

    public function vps()
    {
        return Redirect::to('/admin/vps');
    }

    public function users()
    {
        return Redirect::to('/admin/users');
    }

    public function invoices()
    {
        return Redirect::to('/admin/invoices');
    }

    public function paymentGateways()
    {
        return Redirect::to('/admin/payment-gateways');
    }

    public function webhookLogs()
    {
        return Redirect::to('/admin/webhook-logs');
    }

    public function settings()
    {
        return Redirect::to('/admin/settings');
    }

    public function translations()
    {
        return Redirect::to('/admin/translations');
    }

    public function profile()
    {
        return Redirect::to('/admin/profile');
    }
}
