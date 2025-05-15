<?php

declare(strict_types=1);

namespace App\Livewire\Client;

use Livewire\Component;

class Settings extends Component
{
    public function render()
    {
        return view('livewire.client.settings')
            ->layout('layouts.client');
    }
}
