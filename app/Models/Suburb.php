<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suburb extends Model
{
    use HasFactory;
    protected $fillable = [
        'suburb',
        'latitude',
        'longitude',
    ];

    public static function suburbAsArray(){

        return Suburb::where('status',true)->pluck('suburb','id')->toArray();
    }
}
