<?php

namespace App\Policies;

use App\Models\MailTemplate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailTemplatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; // Allow all users to see the resource
    }

    public function view(User $user, MailTemplate $mailTemplate): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MailTemplate $mailTemplate): bool
    {
        return true;
    }

    public function delete(User $user, MailTemplate $mailTemplate): bool
    {
        return $user->hasRole(['Super-Admin']) || $user->can('mail.manage');
    }
}