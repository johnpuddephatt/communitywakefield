<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'display_until',
        'status',
        'title',
        'slug',
        'content',
        'phone',
        'email',
        'from_home',
        'address',
        'address_ward',
        'postcode',
        'latitude',
        'longitude',
        'directions',
        'times',
        'minimum_age',
        'maximum_age',
        'cost',
        'what_to_bring',
        'qualification',
        'requirements',
        'booking_link',
        'booking_instructions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'team_id' => 'integer',
        'display_until' => 'date',
        'from_home' => 'boolean',
        'latitude' => 'double',
        'longitude' => 'double',
        'minimum_age' => 'integer',
        'maximum_age' => 'integer',
    ];


    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function categories()
    {
        return $this->morphToMany(\App\Models\Category::class, 'categorisable');
    }

    public function accessibilities()
    {
        return $this->morphToMany(\App\Models\Accessibility::class, 'accessible');
    }
}
