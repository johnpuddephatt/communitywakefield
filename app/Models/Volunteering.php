<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WardTrait;
use Illuminate\Support\Str;

class Volunteering extends Model
{
    use HasFactory, SoftDeletes;
    use WardTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'team_id',
        'subteam_id',
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
        'start_date',
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
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'minimum_age' => 'integer',
        'maximum_age' => 'integer',
        'requirements' => 'array',
        'skills_needed' => 'array',
        'skills_gained' => 'array',
    ];

    protected static function booted() {

        static::saving(function($model) {
          $model->slug = Str::slug($model->title);
          $model->content = sanitize_html($model->content);
          $model->address_ward = $model->getWardData($model->postcode);
       });
   }

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function subteam()
    {
        return $this->belongsTo(\App\Models\Subteam::class);
    }

    public function categories()
    {
        return $this->morphToMany(\App\Models\Category::class, 'categorisable');
    }

    public function accessibilities()
    {
        return $this->morphToMany(\App\Models\Accessibility::class, 'accessible');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function suitabilities() {
        return $this->morphToMany(\App\Models\Suitability::class, 'suitable');
    }
}
