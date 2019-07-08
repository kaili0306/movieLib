<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable=[
        'id',
        'title',
        'duration',
        'summary',
        'genre',
        'director',
        'cast',
        'datePublished',
    ];

    public function raters(){
        return $this->belongsToMany(Rater::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
