<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_details extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['movies_id', 'rating_id', 'director_id','language_id'];



    public function movies()
    {
        return $this->belongsTo('movies', 'movies_id', 'id');
    }

    public function mpaa_rating(){
        return $this->hasOne('mpaa_ratings', 'rating_id');

    }

    public function director(){
        return $this->hasOne('directors', 'director_id');

    }

    public function genres(){
        return $this->hasMany('movie_genre', 'movies_id');
    }

    public function performers(){
        return $this->hasMany('movie_performer', 'movies_id');
    }

}
