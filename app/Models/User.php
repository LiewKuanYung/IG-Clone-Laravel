<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // boot method get called when we are booting up this model
    protected static function boot()
    {
        parent::boot(); //call the parent boot first

        static::created(function ($user) { //after created, execute this
            $user->profile()->create([
                'title' => $user->username,
            ]);
        });
    }

    /**
     * One to many relationship
     * 1 User : Many Posts
     * 
     */
    public function posts()
    {                               //DESC order, so that the post latest remain on top
        return $this->hasMany(Post::class)->orderBy('created_at','DESC'); 
                                    //the 'created_at' is field that provided by larabel automatically for timestamp
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    /**
     * One to one relationship
     * 1 User : 1 Profile
     * 
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

}
