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



    public function info()
    {
        return $this->hasOne('App\Models\Movie','id','movies_id');
    }

    public function mpaa_rating(){
        return $this->hasOne('App\Models\Mpaa_rating','id','rating_id');

    }

    public function director(){
        return $this->hasOne('App\Models\Director','id','director_id');

    }

    public function genres(){
        return $this->hasMany('App\Models\Details\Movie_genre', 'movies_id');
    }

    public function performers(){
        return $this->hasMany('movie_performer', 'movies_id');
    }

    public function ratings(){
        return $this->hasMany('App\Models\Rating', 'movie_collections_id');

    }

}
