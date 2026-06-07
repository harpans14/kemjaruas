<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'failed_login_attempts',
        'account_locked',
        'lock_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'account_locked' => 'boolean',
            'lock_until' => 'datetime',
        ];
    }

    public function setoran()
    {
        return $this->hasMany(Setoran::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    public function isAccountLocked(): bool
    {
        if (!$this->account_locked) {
            return false;
        }

        if ($this->lock_until && now()->greaterThan($this->lock_until)) {
            $this->update([
                'account_locked' => false,
                'lock_until' => null,
                'failed_login_attempts' => 0,
            ]);
            return false;
        }

        return true;
    }
}
