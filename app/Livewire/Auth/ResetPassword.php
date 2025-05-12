<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('dashboard')->with('status', __($status));
        }

        $this->addError('email', __($status));
        return null;
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.guest');
    }
}
