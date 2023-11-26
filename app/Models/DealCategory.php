<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealCategory extends Model
{
    use HasFactory;
    protected $table = 'deal_category';

    protected $fillable = [
        'categoryName',
        'categoryStatus',
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'categoryId';

    protected $casts = [
        'categoryStatus' => 'boolean'
    ];

    /**
     * @return HasMany
     */
    public function deals()
    {
        return $this->hasMany(Deals::class,'category','categoryId');
    }

    /**
     * @return HasMany
     */
    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DealSubCategory::class,'categoryId','categoryId');
    }

    /**
     * @return mixed
     */
    public static function categoryAsArray(){
        return DealCategory::where('categoryStatus',true)->pluck('categoryName','categoryId')->toArray();
    }
}
