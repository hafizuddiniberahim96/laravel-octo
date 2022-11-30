<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time_slot extends Model
{
    use HasFactory;
    protected $fillable = ['movie_collections_id','theater_id','room_id','time_start','time_end'];

    protected $casts = [
        'time_start' => 'datetime:Y-m-d H:i:s',
        'time_end' => 'datetime:Y-m-d H:i:s',

    ];

    public function movies(){
        return $this->hasOne('App\Models\Details\Movie_collections','id','movie_collections_id');
    }

    public function theaters(){
        return $this->hasOne(Theater::class,'id','theater_id');
    }

    public function room(){
        return $this->hasOne(Theater_room::class,'id','room_id');
    }

}
