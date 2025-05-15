<?php

declare(strict_types=1);

namespace App\Livewire\Client;

use Livewire\Component;

class Support extends Component
{
    public function render()
    {
        return view('livewire.client.support')
            ->layout('layouts.client');
    }
}
