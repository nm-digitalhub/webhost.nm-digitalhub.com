<?php

namespace App\Services;

use App\Models\ImpersonationLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonationService
{
    /**
     * Start impersonating a user
     *
     * @param  User  $user  The user to impersonate
     * @param  string|null  $reason  Reason for impersonation (optional)
     */
    public function impersonate(User $user, ?string $reason = null): bool
    {
        // Check if the current user can impersonate
        if (! $this->canImpersonate()) {
            return false;
        }

        // Don't allow impersonating yourself
        if (Auth::id() === $user->id) {
            return false;
        }

        // Store the admin ID in the session
        $adminId = Auth::id();
        Session::put('impersonator_id', $adminId);

        // Create a new impersonation log
        $log = ImpersonationLog::create([
            'admin_user_id' => $adminId,
            'impersonated_user_id' => $user->id,
            'started_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'reason' => $reason,
        ]);

        // Store the log ID in the session
        Session::put('impersonation_log_id', $log->id);

        // Login as the impersonated user
        Auth::login($user);

        return true;
    }

    /**
     * Stop impersonating and return to the admin account
     */
    public function stopImpersonating(): bool
    {
        // Check if we are impersonating
        if (! $this->isImpersonating()) {
            return false;
        }

        // Get the admin ID from the session
        $adminId = Session::get('impersonator_id');
        $logId = Session::get('impersonation_log_id');

        // Update the impersonation log
        if ($logId) {
            $log = ImpersonationLog::find($logId);
            if ($log) {
                $log->update([
                    'ended_at' => now(),
                ]);
            }
        }

        // Clear the impersonation session data
        Session::forget('impersonator_id');
        Session::forget('impersonation_log_id');

        // Log back in as the admin
        $admin = User::find($adminId);
        if ($admin) {
            Auth::login($admin);

            return true;
        }

        return false;
    }

    /**
     * Check if the current user is being impersonated
     */
    public function isImpersonating(): bool
    {
        return Session::has('impersonator_id');
    }

    /**
     * Get the impersonator (admin) user
     */
    public function getImpersonator(): ?User
    {
        if (! $this->isImpersonating()) {
            return null;
        }

        $adminId = Session::get('impersonator_id');

        return User::find($adminId);
    }

    /**
     * Check if the current user can impersonate other users
     */
    public function canImpersonate(): bool
    {
        // Only allow impersonation for users with specific permissions
        return Auth::check() && (
            Auth::user()->hasRole('Super-Admin') ||
            Auth::user()->hasRole('Admin') ||
            Auth::user()->can('impersonate-users')
        );
    }

    /**
     * Get all active impersonation sessions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveImpersonations()
    {
        return ImpersonationLog::with(['adminUser', 'impersonatedUser'])
            ->whereNull('ended_at')
            ->orderBy('started_at', 'desc')
            ->get();
    }

    /**
     * Force end all active impersonation sessions
     *
     * @return int Number of ended sessions
     */
    public function endAllImpersonations(): int
    {
        return ImpersonationLog::whereNull('ended_at')
            ->update(['ended_at' => now()]);
    }
}
