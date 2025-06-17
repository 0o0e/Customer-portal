<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    // log user activity
    public static function log(
        User $user,
        string $activityType,
        string $description,
        ?Request $request = null,
    ): UserActivity {
        $request = $request ?? request();
        
        return UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => $request->ip(),
        ]);
    }

    // log a login activity
    public static function logLogin(User $user, Request $request, bool $successful = true): UserActivity
    {
        $activityType = $successful ? 'login' : 'failed_login';
        $description = $successful ? 'User logged in successfully' : 'Failed login attempt';
        
        return self::log($user, $activityType, $description, $request);
    }

    // log a logout activity
    public static function logLogout(User $user, Request $request): UserActivity
    {
        return self::log($user, 'logout', 'User logged out', $request);
    }

    // log a password change activity
    public static function logPasswordChange(User $user, Request $request): UserActivity
    {
        return self::log($user, 'password_change', 'Password changed successfully', $request);
    }

    // log a password reset activity
    public static function logPasswordReset(User $user, Request $request): UserActivity
    {
        return self::log($user, 'password_reset', 'Password reset completed', $request);
    }

}
