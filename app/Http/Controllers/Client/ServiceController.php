<?php

declare(strict_types=1);

namespace App\Http\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the client's services
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $services = Service::where('user_id', $user->id)
            ->orderBy('status')
            ->orderBy('renewal_date')
            ->paginate(10);

        return view('client.services.index', ['services' => $services]);
    }

    /**
     * Display the specified service
     *
     * @return \Illuminate\View\View
     */
    public function show(Service $service)
    {
        // Check that the service belongs to the authenticated user
        if ($service->user_id !== auth()->id()) {
            abort(403, 'לא מורשה לצפות בשירות זה.');
        }

        // Get related invoices for the service
        $invoices = $service->invoices()
            ->orderByDesc('created_at')
            ->get();

        return view('client.services.show', ['service' => $service, 'invoices' => $invoices]);
    }
}
