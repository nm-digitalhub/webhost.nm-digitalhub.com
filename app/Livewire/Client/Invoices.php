<?php

namespace App\Livewire\Client;

use Livewire\Component;

class Invoices extends Component
{
    public function render()
    {
        return view('livewire.client.invoices')
            ->layout('layouts.client');
    }
}
