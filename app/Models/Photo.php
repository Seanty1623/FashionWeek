<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_name',
        'year_level',
        'clothing_type',
        'clothing_subtype',
        'clothing_category',
        'description',
        'image',
        'likes_count',
        'is_outfit',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PhotoLike::class);
    }
}
