<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealImages extends Model
{
    use HasFactory;

    protected $table = 'deal_images';

    protected $fillable = [
        'dealId',
        'imagePath',
        'imageType',
        'status',
    ];

    public function deal()
    {
        return $this->belongsTo(Deals::class, 'dealId', 'dealId');
    }
}
