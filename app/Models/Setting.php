<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'primary_navigation',
        'footer_navigation',
    ];

    protected $casts = [
        'primary_navigation' => 'array',
        'footer_navigation' => 'array'
    ];

    protected static function booted()
    {
        static::updated(function ($model) {
            Cache::forget('settings_' . $model->slug);
        });
    }
}
