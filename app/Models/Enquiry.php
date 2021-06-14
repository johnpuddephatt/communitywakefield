<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\EnquiryCreated;

class Enquiry extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "phone", "email", "message"];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "id" => "integer",
  ];

  protected $dispatchesEvents = [
    "created" => EnquiryCreated::class,
  ];

  public function enquirable()
  {
    return $this->morphTo();
  }
}
