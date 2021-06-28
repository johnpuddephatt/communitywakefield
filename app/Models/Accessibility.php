<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Accessibility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["title", "slug", "icon", "image", "colour"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "id" => "integer",
    ];

    protected static function booted()
    {
        static::saving(function () {
            Cache::flush();
        });
    }

    public function activities()
    {
        return $this->morphedByMany(\App\Models\Activity::class, "accessible");
    }

    public function courses()
    {
        return $this->morphedByMany(\App\Models\Course::class, "accessible");
    }

    public function events()
    {
        return $this->morphedByMany(\App\Models\Event::class, "accessible");
    }

    public function services()
    {
        return $this->morphedByMany(\App\Models\Service::class, "accessible");
    }

    public function volunteerings()
    {
        return $this->morphedByMany(\App\Models\Volunteering::class, "accessible");
    }
}
