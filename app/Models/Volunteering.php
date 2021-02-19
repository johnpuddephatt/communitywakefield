<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteering extends Model
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
        'postcode',
        'address_ward',
        'latitude',
        'longitude',
        'directions',
        'places',
        'start date',
        'end_date',
        'frequency',
        'hours',
        'deadline',
        'minimum_age',
        'maximum_age',
        'expenses',
        'what_to_bring',
        'requirements',
        'skills_needed',
        'skills_gained',
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
        'start date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
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

    public function suitabilities() {
        return $this->belongsToMany(\App\Models\VolunteeringSuitability::class, 'volunteering_suitabilities_pivot');
    }
}
