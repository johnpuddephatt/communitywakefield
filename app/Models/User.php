<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Concerns\IsFilamentUser;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Jetstream\HasTeams;
use App\Traits\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use IsFilamentUser;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Impersonate;

    public static $filamentUserColumn = "is_admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["name", "email", "password", "notification_emails"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password",
        "remember_token",
        "two_factor_recovery_codes",
        "two_factor_secret",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "notification_emails" => AsArrayObject::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ["profile_photo_url"];

    public static $notificationEmails = [
        "TeamMemberAutojoined" => "Someone automatically joins an organisation I created",
        "TeamMemberRequestReceived" =>
            "Someone requests to join an organisation I administer",
        "TeamMemberRequestApproved" =>
            "My request to join an organisation has been approved",
        "EntryExpiresSoon" => "One of my listings will expire soon",
        "EntryExpired" => "One of my listings has expired",
        "EntryReported" => "An inaccuracy has been reported in one of my listings",
        "EnquiryCreated" => "An enquiry has been received about a listing I created",
        "TeamEnquiryCreated" =>
            "An enquiry has been received about any of my team’s listings",
    ];

    public function canImpersonate()
    {
        return $this->is_admin == 1;
    }

    public function receives($notification)
    {
        return $this->notification_emails &&
            in_array($notification, $this->notification_emails->toArray());
    }

    public function scopeAdmins($query)
    {
        return $query->where("is_admin", true);
    }

    public function teamRequests()
    {
        return $this->hasMany(\App\Models\TeamRequest::class);
    }
}
