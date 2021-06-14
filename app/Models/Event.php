<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WardTrait;
use App\Traits\DateTrait;
use App\Traits\PublishedTrait;
use App\Traits\HasFiltersTrait;
use Malhal\Geographical\Geographical;
use Illuminate\Support\Str;

class Event extends Model
{
  use HasFactory;
  use SoftDeletes;
  use WardTrait;
  use DateTrait;
  use Geographical;
  use HasFiltersTrait;
  use PublishedTrait;

  public static $name = "Events";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "created_by",
    "updated_by",
    "team_id",
    "subteam_id",
    "start_date",
    "end_date",
    "status",
    "title",
    "slug",
    "content",
    "phone",
    "email",
    "from_home",
    "address",
    "address_ward",
    "postcode",
    "latitude",
    "longitude",
    "directions",
    "times",
    "minimum_age",
    "maximum_age",
    "cost",
    "what_to_bring",
    "booking_link",
    "booking_instructions",
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "id" => "integer",
    "team_id" => "integer",
    "start date" => "date",
    "end_date" => "date",
    "from_home" => "boolean",
    "latitude" => "double",
    "longitude" => "double",
    "minimum_age" => "integer",
    "maximum_age" => "integer",
  ];

  protected static function booted()
  {
    static::saving(function ($model) {
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
    return $this->morphToMany(\App\Models\Category::class, "categorisable");
  }

  public function accessibilities()
  {
    return $this->morphToMany(\App\Models\Accessibility::class, "accessible");
  }

  public function enquiries()
  {
    return $this->morphMany(\App\Models\Enquiry::class, "enquirable");
  }

  public function creator()
  {
    return $this->belongsTo(\App\Models\User::class, "created_by");
  }

  public function updater()
  {
    return $this->belongsTo(\App\Models\User::class, "updated_by");
  }
}
