<?php

namespace App\Livewire\Admin;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DomainsNew extends Component
{
    public $name;

    public $domain_type = 'new';

    public $client_id;

    public $period = 1;

    public $nameserver1 = 'ns1.webhost.nm-digitalhub.com';

    public $nameserver2 = 'ns2.webhost.nm-digitalhub.com';

    public $clients = [];

    protected $rules = [
        'name' => 'required|string|min:3|max:100|unique:domains,name',
        'domain_type' => 'required|in:new,transfer,external',
        'client_id' => 'required|exists:users,id',
        'period' => 'required|integer|min:1|max:10',
        'nameserver1' => 'required|string',
        'nameserver2' => 'required|string',
    ];

    public function mount()
    {
        // Load clients for the dropdown
        $this->clients = User::where('role', 'client')->get();

        // If no clients found with 'role' column, try using roles relationship
        if ($this->clients->isEmpty()) {
            $this->clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->get();
        }
    }

    public function submit()
    {
        $validatedData = $this->validate();

        try {
            DB::beginTransaction();

            // Domain creation logic
            Domain::create([
                'name' => $validatedData['name'],
                'domain_type' => $validatedData['domain_type'],
                'client_id' => $validatedData['client_id'],
                'period' => $validatedData['period'],
                'nameserver1' => $validatedData['nameserver1'],
                'nameserver2' => $validatedData['nameserver2'],
                'status' => 'pending',
                'expiration_date' => now()->addYears($validatedData['period']),
            ]);

            DB::commit();
            session()->flash('message', 'הדומיין נוצר בהצלחה!');

            return redirect()->route('admin.domains');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'אירעה שגיאה ביצירת הדומיין: '.$e->getMessage());
        }

        return null;
    }

    public function render()
    {
        // If layout is already applied at route level, the component-level layout will be ignored
        return view('livewire.admin.domains-new')
            ->layout('livewire.admin.layout');
    }
}
