<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Movie_collections extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['movies_id', 'rating_id', 'director_id','language_id'];



    public function movie()
    {
        return $this->hasOne('App\Models\Movie','id');
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
