<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConfirmPassword extends Component
{
    public $password = '';

    protected $rules = [
        'password' => 'required|current_password',
    ];

    public function confirm()
    {
        $this->validate();

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(url()->previous());
    }

    public function render()
    {
        return view('livewire.auth.confirm-password')
            ->layout('layouts.app');
    }
}
