<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Carbon\Carbon;


class Movie extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'length', 'release','description'];
    protected $dates = ['release'];
    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'length' => 'integer',
        'release' => 'date:Y-m-d',
    ];


    public function details()
    {
        return $this->belongsTo('App\Models\Details\Movie_collections','movies_id');
    }

 

    

}
