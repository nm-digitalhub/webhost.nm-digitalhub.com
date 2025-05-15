<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImpersonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImpersonationController extends Controller
{
    protected $impersonationService;

    public function __construct(ImpersonationService $impersonationService)
    {
        $this->impersonationService = $impersonationService;
    }

    /**
     * Start impersonating a user
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function impersonate(Request $request, $userId)
    {
        // Ensure user has permission to impersonate
        if (!$this->impersonationService->canImpersonate()) {
            abort(403, 'Unauthorized action.');
        }

        // Find the user to impersonate
        $user = User::findOrFail($userId);

        // Start impersonation
        $reason = $request->input('reason');
        $success = $this->impersonationService->impersonate($user, $reason);

        if (!$success) {
            return redirect()->back()->with('error', 'Failed to impersonate user.');
        }

        return redirect()->route('client.dashboard')
            ->with('warning', 'You are now impersonating ' . $user->name . '. Remember to exit impersonation when finished.');
    }

    /**
     * Stop impersonating and return to admin account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stopImpersonating()
    {
        $success = $this->impersonationService->stopImpersonating();

        if (!$success) {
            return redirect()->back()->with('error', 'Not currently impersonating any user.');
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Exited impersonation mode.');
    }

    /**
     * Show the active impersonation sessions (Admin only)
     *
     * @return \Illuminate\View\View
     */
    public function activeSessions()
    {
        // Only super admins can see active sessions
        if (!auth()->user()->hasRole('Super-Admin')) {
            abort(403);
        }

        $sessions = $this->impersonationService->getActiveImpersonations();
        return view('admin.impersonation.sessions', ['sessions' => $sessions]);
    }

    /**
     * End all active impersonation sessions (Admin only)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function endAllSessions()
    {
        // Only super admins can end all sessions
        if (!auth()->user()->hasRole('Super-Admin')) {
            abort(403);
        }

        $count = $this->impersonationService->endAllImpersonations();

        return redirect()->back()
            ->with('success', "{$count} active impersonation sessions have been ended.");
    }
}