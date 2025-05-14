<?php

namespace App\Livewire\Client;

use Livewire\Component;

class HostingNew extends Component
{
    public $selectedPlan;

    public $billingCycle = 'monthly';

    public $domainOption = 'new';

    public $domain = '';

    public $configurations = [];

    public function mount()
    {
        $this->configurations = [
            'basic' => [
                'storage' => '10 GB',
                'websites' => 1,
                'price' => [
                    'monthly' => 4.99,
                    'annually' => 49.99,
                ],
            ],
            'premium' => [
                'storage' => '25 GB',
                'websites' => 10,
                'price' => [
                    'monthly' => 9.99,
                    'annually' => 99.99,
                ],
            ],
            'business' => [
                'storage' => '100 GB',
                'websites' => 'Unlimited',
                'price' => [
                    'monthly' => 19.99,
                    'annually' => 199.99,
                ],
            ],
        ];
    }

    public function selectPlan($plan)
    {
        $this->selectedPlan = $plan;
    }

    public function setBillingCycle($cycle)
    {
        $this->billingCycle = $cycle;
    }

    public function placeOrder()
    {
        // Validate input
        $this->validate([
            'selectedPlan' => 'required|in:basic,premium,business',
            'billingCycle' => 'required|in:monthly,annually',
            'domainOption' => 'required|in:new,existing,none',
            'domain' => 'required_if:domainOption,new,existing',
        ]);

        // Process the order
        // This would connect to a payment processor and create the hosting account

        // Redirect to confirmation page
        // return redirect()->route('client.hosting.confirmation', ['orderId' => $orderId]);
    }

    public function render()
    {
        return view('livewire.client.hosting-new')
            ->layout('layouts.client');
    }
}

namespace App\Http\Livewire\Client;

use Livewire\Component;

class HostingNew extends Component
{
    public $plan = '';

    public $domain = '';

    public function createHosting()
    {
        $this->validate([
            'plan' => 'required',
            'domain' => 'required|string',
        ]);

        // Hosting creation logic will go here
    }

    public function render()
    {
        return view('livewire.client.hosting-new')
            ->layout('layouts.client');
    }
}
