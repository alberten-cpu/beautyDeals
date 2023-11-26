<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealRepeat extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'deal_repeats';

    /**
     * @var string
     */
    protected $primaryKey = 'repeatId';

    /**
     * @var string[]
     */
    protected $fillable = [
        'dealId',
        'sTime',
        'eTime',
        'repeat',
        'status'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'sTime' => 'datetime:H:i:s',
        'eTime' => 'datetime:H:i:s',
        'status' => 'boolean',
    ];
    public function deal()
    {
        return $this->belongsTo(Deals::class, 'dealId', 'dealId');
    }
}
