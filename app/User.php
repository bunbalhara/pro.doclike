<?php

namespace App;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Categories;


class User extends Authenticatable implements ShouldQueue
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection='mysql2';
    protected $table="users";
    protected $primaryKey  = 'id';
    /**
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function type($id)
    {
        return Categories::find($id)->image;
    }

    public function userType()
    {
        if ($this->user_type == 2) {
            if ($this->categories) {
                return $this->categories->name;
            } else {
                return 'General';
            }
        } else if ($this->user_type == 3) {
            return 'Patient';
        } else {
            return 'Admin';
        }
    }

    public function categories()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'category');
    }

    public function profileImg() {
        $image = auth()->user()->profile_img;
        if ($image) {
            return $image;
        } else {
            return asset('front/img/user_logo.png');
        }
    }

    public function image() {
        if ($this->avatar) {
            return asset($this->avatar);
        } else {
            if ($this->user_type == 2) {
                return asset('front/img/doctor-thumb-02.jpg');
            } else {
                return asset('front/img/user_logo.png');
            }
        }

        return $this->name;
    }

    public function favourite() {
        return $this->hasMany('App\Models\FavouriteDoctor', 'doctor_id')->where('status', 1);
    }

    public function appointments() {
        return $this->hasMany('App\Models\Appointment', 'user_id')->orderBy('created_at', 'desc');
    }
}
