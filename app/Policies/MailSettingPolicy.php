<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MailSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailSettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; // Allow all users to see the resource
    }

    public function view(User $user, MailSetting $mailSetting): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MailSetting $mailSetting): bool
    {
        return true;
    }

    public function delete(User $user, MailSetting $mailSetting): bool
    {
        return $user->hasRole(['Super-Admin']) || $user->can('mail.manage');
    }
}
