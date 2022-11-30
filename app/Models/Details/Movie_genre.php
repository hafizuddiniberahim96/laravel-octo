<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_genre extends Model
{
    use HasFactory;
    protected $fillable = ['movie_collections_id', 'genre_id'];



    public function genres(){
        return $this->hasOne('App\Models\Genre', 'id','genre_id');
    }

    public function movies(){
        return $this->hasMany(Movie_collections::class,'id','movie_collections_id');
    }

    
}
