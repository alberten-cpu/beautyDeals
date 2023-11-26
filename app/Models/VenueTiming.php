<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTiming extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'venue_timing';
    /**
     * @var string[]
     */
    protected $fillable = [
        'venueId',
        'day',
        'openTime',
        'closeTime',
        'status',
        ];

        protected $hidden = [
            'created_at',
            'updated_at',
        ];

    public function venue()
    {
        return $this->belongsTo(Venues::class, 'venueId', 'venueId');
    }
}
