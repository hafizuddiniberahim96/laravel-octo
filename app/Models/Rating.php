<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['movie_collections_id','user_id','rating','r_description'];


    public function movie(){
        return $this->hasOne('App\Models\Details\Movie_collections','id','movie_collections_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
