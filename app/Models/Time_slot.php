<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time_slot extends Model
{
    use HasFactory;
    protected $fillable = ['movie_collections_id','theater_id','time_start','time_end'];

    protected $casts = [
        'time_start' => 'datetime:Y-m-d H:i:s',
        'time_end' => 'datetime:Y-m-d H:i:s',

    ];

    public function movies(){
        $this->hasOne('App\Models\Details\Movie_collections','id');
    }

    public function theaters(){
        return $this->belongsTo('Theater','id');
    }

}
