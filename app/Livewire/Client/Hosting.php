<?php

declare(strict_types=1);

namespace App\Livewire\Client;

use Livewire\Component;

class Hosting extends Component
{
    public function render()
    {
        return view('livewire.client.hosting')
            ->layout('layouts.client');
    }
}
