<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Fortify;

class ConfirmPassword
{
    /**
     * Confirm that the given password is valid for the given user.
     *
     * @param  mixed  $user
     * @param  string  $password
     * @return bool
     */
    public function __invoke($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Get the password confirmation view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\ConfirmPasswordViewResponse
     */
    public function show($request)
    {
        return app(ConfirmPasswordViewResponse::class);
    }

    /**
     * Confirm the user's password.
     *
     * @param  mixed  $user
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function confirm($user, $request)
    {
        $request->session()->put('auth.password_confirmed_at', time());

        return app(PasswordConfirmedResponse::class);
    }
}
