<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


   
    public function time_slots(){
       return $this->hasMany(Time_slot::class,'theater_id');
    }

    public function rooms(){
        return $this->hasMany(Theater_room::class,'theater_id');

    }

}
