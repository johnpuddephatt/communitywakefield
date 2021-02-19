<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
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
        return $this->morphedByMany(\App\Model\Activity::class, 'accessible');
    }

    public function courses()
    {
        return $this->morphedByMany(\App\Model\Course::class, 'accessible');
    }

    public function events()
    {
        return $this->morphedByMany(\App\Model\Event::class, 'accessible');
    }

    public function services()
    {
        return $this->morphedByMany(\App\Model\Service::class, 'accessible');
    }

    public function volunteerings()
    {
        return $this->morphedByMany(\App\Model\Volunteering::class, 'accessible');
    }
}
