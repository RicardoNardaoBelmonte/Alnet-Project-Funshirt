<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'user_type', 'gender', 'blocked', 'photo_url', 'custom'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'blocked' => 'boolean',
        ];
    }

    // Backward-compatibility accessor so `$user->admin` still works throughout old code
    public function getAdminAttribute(): bool
    {
        return $this->user_type === 'A';
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'A';
    }

    public function isEmployee(): bool
    {
        return $this->user_type === 'F';
    }

    public function isCustomer(): bool
    {
        return $this->user_type === 'C';
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getPhotoFullUrlAttribute(): string
    {
        if ($this->photo_url && Storage::disk('public')->exists("photos/{$this->photo_url}")) {
            return asset("storage/photos/{$this->photo_url}");
        }

        return asset('storage/photos/anonymous.png');
    }

    public function customer(): HasOne
    {
        // customers.id = users.id (not autoincrement, id is the FK)
        return $this->hasOne(Customer::class, 'id', 'id');
    }

    /**
     * Send the email verification notification using Mailtrip.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }
}