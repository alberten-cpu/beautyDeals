<?php

namespace Database\Seeders;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::create([
            'venueCategoryId' => 1,
            'venueSubCategoryName' => 'Pilsner',
            'venueSubCategoryStatus' => true,
        ]);

        SubCategory::create([
            'venueCategoryId' => 1,
            'venueSubCategoryName' => 'BroCodeilsener',
            'venueSubCategoryStatus' => true,

        ]);
        SubCategory::create([
            'venueCategoryId' => 1,
            'venueSubCategoryName' => 'Berliner Kindl',
            'venueSubCategoryStatus' => true,

        ]);
        SubCategory::create([
            'venueCategoryId' => 2,
            'venueSubCategoryName' => 'J D',
            'venueSubCategoryStatus' => true,

        ]);
        SubCategory::create([
            'venueCategoryId' => 2,
            'venueSubCategoryName' => 'Johny Walker',
            'venueSubCategoryStatus' => true,

        ]);
        SubCategory::create([
            'venueCategoryId' => 2,
            'venueSubCategoryName' => 'Jawan',
            'venueSubCategoryStatus' => true,

        ]);
    }
}
