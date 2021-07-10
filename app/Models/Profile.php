<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];    //disable mass assingment
                                //we're doing this because the code in controller has careful validation

    public function profileImage()
    {
        $imagePath = ($this->image) ? '/storage/' . $this->image : '/png/default-profile.jpg';
        return  $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class); 
    }

    /** 
     * This function is using naming convention, 
     * the "user" function has the same name with the table name
     * If the naming is diff, then you will have to include one more paramters to specify it
     * read more about relationship in laravel documentation
     */
     public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
