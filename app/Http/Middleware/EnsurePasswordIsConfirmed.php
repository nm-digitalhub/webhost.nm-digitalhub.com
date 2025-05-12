<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;

class EnsurePasswordIsConfirmed
{
    /**
     * The response factory instance.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $responseFactory;

    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $urlGenerator;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $passwordTimeoutSeconds
     * @return mixed
     */
    public function handle($request, Closure $next, $passwordTimeoutSeconds = null)
    {
        if ($this->shouldConfirmPassword($request, $passwordTimeoutSeconds)) {
            if ($request->expectsJson()) {
                return $this->responseFactory->json([
                    'message' => 'Password confirmation required.',
                ], 423);
            }

            return $this->responseFactory->redirectGuest(
                $this->urlGenerator->route('auth.password.confirm')
            );
        }

        return $next($request);
    }

    /**
     * Determine if the password needs to be confirmed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $passwordTimeoutSeconds
     * @return bool
     */
    protected function shouldConfirmPassword($request, $passwordTimeoutSeconds = null)
    {
        $passwordTimeoutSeconds = $passwordTimeoutSeconds ?: config('auth.password_timeout', 10800);

        return $request->session()->has('auth.password_confirmed_at') === false ||
               $request->session()->get('auth.password_confirmed_at') <= (time() - $passwordTimeoutSeconds);
    }
}
