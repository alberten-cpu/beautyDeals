<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Deals extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'deals';

    /**
     * @var string
     */
    protected $primaryKey = 'dealId';

    /**
     * @var string[]
     */
    protected $fillable = [
        'venueId',
        'title',
        'description',
        'category',
        'subCategory',
        'price',
        'startDate',
        'isRepeat',
        'repeatEndDate',
        'repeatWeeks',
        'isExclusive',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'startDate' => 'datetime:Y-m-d',
        'repeatEndDate' => 'datetime:Y-m-d',
        'isExclusive' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function dealRepeat(): HasMany
    {
        return $this->hasMany(DealRepeat::class,'dealId','dealId');
    }

    /**
     * @return HasMany
     */
    public function dealImages(): HasMany
    {
        return $this->hasMany(DealImages::class,'dealId', 'dealId');
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venues::class, 'venueId', 'venueId');
    }

    /**
     * @param $venueId
     * @return mixed
     */
    public static function dealCountByVenueId($venueId): mixed
    {
        return Deals::where('venueId', $venueId)->count();
    }
}
