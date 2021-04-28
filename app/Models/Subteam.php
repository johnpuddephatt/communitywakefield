<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subteam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'info'
    ];

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function activities()
    {
        return $this->hasMany(\App\Models\Activity::class);
    }
}
