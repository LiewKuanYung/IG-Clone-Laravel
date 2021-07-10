<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    /**
     * Passing nothing into $guarded
     * Telling Laravel, to not gaurd anything
     * The gaurd is useful to gaurd your database
     * and avoid other people to add any new fields into your database
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
