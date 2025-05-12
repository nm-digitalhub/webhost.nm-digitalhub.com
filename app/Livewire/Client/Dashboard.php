<?php

namespace App\Livewire\Client;

use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $activeDomains;
    public $activeHosting;
    public $activeVps;
    public $pendingInvoices;
    public $domains;
    public $invoices;

    public function mount()
    {
        // בפרויקט אמיתי, כאן תהיה שליפת נתונים מבסיס הנתונים
        // לפי המשתמש המחובר (Auth::user())
        $this->activeDomains = 3;
        $this->activeHosting = 1;
        $this->activeVps = 0;
        $this->pendingInvoices = 1;

        // הכנת נתוני דומיינים לדוגמה
        $this->domains = $this->getSampleDomains();

        // הכנת נתוני חשבוניות לדוגמה
        $this->invoices = $this->getSampleInvoices();
    }

    public function render()
    {
        return view('livewire.client.dashboard');
    }

    /**
     * נתונים לדוגמה לדומיינים
     */
    private function getSampleDomains()
    {
        return collect([
            (object) [
                'name' => 'example.co.il',
                'renewal_date' => Carbon::createFromDate(2023, 10, 15),
                'status' => 'פעיל',
            ],
            (object) [
                'name' => 'mysite.co.il',
                'renewal_date' => Carbon::createFromDate(2023, 12, 2),
                'status' => 'פעיל',
            ],
            (object) [
                'name' => 'mynewdomain.com',
                'renewal_date' => Carbon::createFromDate(2024, 5, 25),
                'status' => 'פעיל',
            ],
        ]);
    }

    /**
     * נתונים לדוגמה לחשבוניות
     */
    private function getSampleInvoices()
    {
        return collect([
            (object) [
                'number' => '1234',
                'date' => Carbon::createFromDate(2023, 6, 1),
                'description' => 'חידוש אחסון',
                'amount' => 149.00,
                'status' => 'pending',
            ],
            (object) [
                'number' => '1233',
                'date' => Carbon::createFromDate(2023, 5, 15),
                'description' => 'חידוש דומיין',
                'amount' => 59.00,
                'status' => 'paid',
            ],
            (object) [
                'number' => '1232',
                'date' => Carbon::createFromDate(2023, 5, 1),
                'description' => 'חידוש אחסון',
                'amount' => 149.00,
                'status' => 'paid',
            ],
        ]);
    }
}
