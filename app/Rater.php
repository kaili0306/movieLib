<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rater extends Model
{
    protected $fillable=[
        'id',
        'name',
    ];

    public function comments(){
        return $this->belongsToMany(Comment::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class);
    }
}
