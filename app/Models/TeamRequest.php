<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;

class TeamRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
    ];

    protected $table = 'team_requests';

    /**
     * Get the team that the request is for
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Jetstream::teamModel());
    }

    /**
     * Get the user that created the request
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
