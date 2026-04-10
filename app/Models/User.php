<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'is_premium'         => 'boolean',
            'is_active'          => 'boolean',
            'premium_expires_at' => 'datetime', 
        ];
    }

    public function isAdmin() 
    {
        return $this->role === 'admin';
    }

    public function hasPremiumAccess() 
    {
        if ($this->is_premium && $this->premium_expires_at && $this->premium_expires_at->isPast()) {
            
            $this->update([
                'is_premium'         => false,
                'premium_expires_at' => null 
            ]);

            return false; 
        }

        return $this->is_premium;
    }

    public function activatePremium()
    {
        $this->update([
            'is_premium'         => true,
            'premium_expires_at' => now()->addMonth(), 
        ]);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=e0f2fe&color=0369a1&size=128";
    }
}