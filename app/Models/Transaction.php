<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updated(function ($transaction) {
            if ($transaction->status === 'approved' && $transaction->wasChanged('status')) {
                if ($transaction->user) {
                    $transaction->user->activatePremium();
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}