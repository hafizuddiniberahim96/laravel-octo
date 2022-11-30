<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater_room extends Model
{
    use HasFactory;
    protected $fillable = ['theater_id','name','available'];

    protected $casts = [
        'availability' => 'boolean',
    ];


    public function theaters(){
        return $this->belongsTo(Theaters::class,'id','theater_id');
    }
    

}
