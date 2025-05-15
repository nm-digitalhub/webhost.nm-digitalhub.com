<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyEmail extends Component
{
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        auth()->user()->sendEmailVerificationNotification();

        $this->dispatch('resent');

        session()->flash('resent');

        return null;
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.app');
    }
}
