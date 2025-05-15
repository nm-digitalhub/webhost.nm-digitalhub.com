<?php

declare(strict_types=1);

namespace App\Livewire\Client;

use Livewire\Attributes\Validate;
use Livewire\Component;

class SupportNew extends Component
{
    #[Validate('required|string|min:3|max:100')]
    public $subject = '';

    #[Validate('required|string|min:10')]
    public $message = '';

    #[Validate('required|in:low,medium,high')]
    public $priority = 'medium';

    public function createTicket()
    {
        $this->validate([
            'subject' => 'required|string|min:3|max:100',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Ticket creation logic will go here
    }

    public function render()
    {
        return view('livewire.client.support-new')
            ->layout('layouts.client');
    }
}
