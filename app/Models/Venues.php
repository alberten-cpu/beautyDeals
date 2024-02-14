<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Venues extends Model
{
    use HasFactory;

    protected $table = 'venues';
    protected $primaryKey = 'venueId';

    protected $fillable = [
        'venueId',
        'userId',
        'venueName',
        'venueDescription',
        'venueType',
        'venueCategoryId',
        'venueSubCategoryId',
        'venueWebsite',
        'website',
        'phone_number',
        'venueAddress',
        'suburbId',
        'country',
        'placeName',
        'latitude',
        'longitude',
        'venueStatus',
    ];

    protected $hidden = [
        'last_seen',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    public static $days = [
        'sunday' => 'Sunday',
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
    ];

    protected $casts = [
        'venueStatus' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function suburb(): BelongsTo
    {
        return $this->belongsTo(Suburb::class, 'suburbId', 'id');
    }

    /**
     * @return HasMany
     */
    public function timing(): HasMany
    {
        return $this->hasMany(VenueTiming::class, 'venueId', 'venueId');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(UserImages::class, 'userId', 'userId');
    }

    /**
     * @return mixed
     */
    public static function venueAsArray(): mixed
    {
        return Venues::where('venueStatus', true)->pluck('venueName', 'venueId')->toArray();
    }

    /**
     * @param $venueId
     * @return User
     */
    public static function getUserByVenueId($venueId): User
    {
        $venue = Venues::select('userId','venueId')->findOrFail($venueId);
        return User::findOrFail($venue->userId);
    }

    /**
     * @param $userId
     * @return Venues
     */
    public static function geVenueByUserId($userId): Venues
    {
        return Venues::where('userId',$userId)->firstOrFail();
    }
}
