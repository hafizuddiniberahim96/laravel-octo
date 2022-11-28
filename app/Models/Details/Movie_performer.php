<?php

namespace App\Models\Details;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_performer extends Model
{
    use HasFactory;
    protected $fillable = ['movie_collections_id', 'performer_id'];

}
