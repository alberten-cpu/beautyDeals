<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'imagePath',
        'imageType',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userId', 'userId');
    }
}
