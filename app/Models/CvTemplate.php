<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CvTemplate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'layout_schema' => 'array',
        'global_settings' => 'array',
        'tags' => 'array',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected function isNew(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return false;
                }

                return $this->created_at->diffInDays(now()) <= 14;
            }
        );
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }
}
