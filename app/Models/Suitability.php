<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suitability extends Model
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
        'type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function volunteerings()
    {
        return $this->morphedByMany(\App\Models\Volunteering::class, 'suitable');
    }

    public function services()
    {
        return $this->morphedByMany(\App\Models\Service::class, 'suitable');
    }
}
