<?php

namespace App;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,Billable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Get The proper date

    public function getcreatedAtAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }

    //  Get The Candidate of HR selected

    public function getCandidate()
    {
        return $this->hasMany(Interview::class,'hr_id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Get The Plan
    public function getPlan()
    {
        return $this->hasOne(Plan::class);
    }
    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }
}
