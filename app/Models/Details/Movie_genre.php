<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_genre extends Model
{
    use HasFactory;
    protected $fillable = ['movie_details_id', 'genre_id'];

}
