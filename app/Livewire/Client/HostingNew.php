<?php

declare(strict_types=1);

namespace App\Livewire\Client;

use Livewire\Component;

class HostingNew extends Component
{
    // הגדרת משתנים
    public $selectedPlan;

    public $billingCycle = 'monthly';

    public $domainOption = 'new';

    public $domain = '';

    public $configurations = [];

    // אתחול קונפיגורציות החבילות
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

    // פונקציה לבחירת תוכנית
    public function selectPlan($plan)
    {
        $this->selectedPlan = $plan;
    }

    // פונקציה לקביעת מחזור החיוב
    public function setBillingCycle($cycle)
    {
        $this->billingCycle = $cycle;
    }

    // פונקציה למקום הזמנת אחסון
    public function placeOrder()
    {
        // אימות קלט
        $this->validate([
            'selectedPlan' => 'required|in:basic,premium,business',
            'billingCycle' => 'required|in:monthly,annually',
            'domainOption' => 'required|in:new,existing,none',
            'domain' => 'required_if:domainOption,new,existing',
        ]);

        // תהליך ביצוע ההזמנה (לוגיקה לתשלום והזמנת אחסון)

        // הפנייה לדף אישור
        // return redirect()->route('client.hosting.confirmation', ['orderId' => $orderId]);
    }

    // פונקציה להוספת אתר חדש (הייתה במחלקה השנייה)
    public function createHosting()
    {
        $this->validate([
            'plan' => 'required',
            'domain' => 'required|string',
        ]);

        // לוגיקה להקמת אחסון תתווסף כאן
    }

    // פונקציה להציג את התצוגה של Livewire
    public function render()
    {
        return view('livewire.client.hosting-new')
            ->layout('layouts.client');
    }
}
