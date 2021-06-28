<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use App\Scopes\NonPersonalTeamScope;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "personal_team" => "boolean",
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "personal_team",
        "phone",
        "email",
        "website",
        "auto_join",
        "info",
        "logo",
        "slug",
    ];

    protected static function booted()
    {
        // static::addGlobalScope(new NonPersonalTeamScope);
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
            Cache::flush();
        });
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        "created" => TeamCreated::class,
        "updated" => TeamUpdated::class,
        "deleted" => TeamDeleted::class,
    ];

    public function subteams()
    {
        return $this->hasMany(\App\Models\Subteam::class);
    }

    public function teamRequests()
    {
        return $this->hasMany(\App\Models\TeamRequest::class);
    }

    public function activities()
    {
        return $this->hasMany(\App\Models\Activity::class);
    }

    public function services()
    {
        return $this->hasMany(\App\Models\Service::class);
    }

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function volunteerings()
    {
        return $this->hasMany(\App\Models\Volunteering::class);
    }

    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }
}
