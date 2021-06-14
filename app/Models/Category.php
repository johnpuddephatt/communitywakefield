<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'type',
        'icon',
        'image',
        'colour',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function activities()
    {
        return $this->morphedByMany(\App\Models\Activity::class, 'categorisable');
    }

    public function courses()
    {
        return $this->morphedByMany(\App\Models\Course::class, 'categorisable');
    }

    public function events()
    {
        return $this->morphedByMany(\App\Models\Event::class, 'categorisable');
    }

    public function services()
    {
        return $this->morphedByMany(\App\Models\Service::class, 'categorisable');
    }

    public function volunteerings()
    {
        return $this->morphedByMany(\App\Models\Volunteering::class, 'categorisable');
    }
}
