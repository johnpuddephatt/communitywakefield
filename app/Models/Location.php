<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "icon", "latitude", "longitude", "radius"];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
            Cache::flush();
        });
    }
}
