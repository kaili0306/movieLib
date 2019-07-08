<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'id',
        'rate',
        'comment',
        'rater_id',
    ];

    public function raters(){
        return $this->belongsToMany(Rater::class);
    }
}




