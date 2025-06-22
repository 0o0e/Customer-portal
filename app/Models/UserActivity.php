<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivityDescription(): string
    {
        return match($this->activity_type) {
            'login' => 'Successfully logged in',
            'logout' => 'Logged out',
            'password_change' => 'Password changed',
            'password_reset' => 'Password reset',
            'failed_login' => 'Failed login attempt',
            default => $this->description,
        };
    }

    public function getActivityIcon(): string
    {
        return match($this->activity_type) {
            'login' => 'fas fa-sign-in-alt text-success',
            'logout' => 'fas fa-sign-out-alt text-info',
            'password_change' => 'fas fa-key text-warning',
            'password_reset' => 'fas fa-unlock text-warning',
            'failed_login' => 'fas fa-exclamation-triangle text-danger',
            default => 'fas fa-info-circle text-secondary',
        };
    }

    public function isSuspicious(): bool
    {
        return $this->activity_type === 'failed_login';
    }
}