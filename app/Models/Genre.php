<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    // public function genres(){
    //     return $this->hasMany('App\Models\Details\Movie_genre','genre_id');
    // }

    public function test(){
        return $this->hasOne('App\Models\Details\Movie_genre', 'id');

    }

}
