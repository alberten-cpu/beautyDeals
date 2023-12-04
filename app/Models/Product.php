<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'venueId',
        'title',
        'description',
        'price',
        'status',
    ];

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImages::class,'productId', 'id');
    }
    public function venue(): HasOne
    {
        return $this->hasOne(Venues::class,'venueId', 'venueId');
    }

}
