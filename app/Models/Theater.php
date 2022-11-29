<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;
    protected $fillable = ['name'];



    public function time_slots(){
       return $this->hasMany('App\Models\Time_slot','theater_id');
    }
}
