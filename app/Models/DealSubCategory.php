<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealSubCategory extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'deal_sub_category';

    /**
     * @var string[]
     */
    protected $fillable = [
        'dealCategoryId',
        'dealSubCategoryName',
        'dealSubCategoryStatus',
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'dealSubCategoryId';

    /**
     * @var string[]
     */
    protected $casts = [
        'dealSubCategoryStatus' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(DealCategory::class,'dealCategoryId');
    }

    /**
     * @return mixed
     */
    public static function subCategoryAsArray(){
        return DealSubCategory::where('dealSubCategoryStatus',true)->pluck('dealSubCategoryName','dealSubCategoryId')->toArray();
    }
}
