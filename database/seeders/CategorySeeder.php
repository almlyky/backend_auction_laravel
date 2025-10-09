<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name_ar'=>'سيارات',
                'name_en'=>'Cars',
            ],
            [
                'name_ar'=>'عقارات',
                'name_en'=>'Real Estate',
            ],
            [
                'name_ar'=>'الكترونيات',
                'name_en'=>'Electronics',
            ],
            [
                'name_ar'=>'اثاث',
                'name_en'=>'Furniture',
            ],
            [
                'name_ar'=>'ازياء',
                'name_en'=>'Fashion',
            ],
            [
                'name_ar'=>'مجوهرات',
                'name_en'=>'Jewelry',
            ],
            [
                'name_ar'=>'ساعات',
                'name_en'=>'Watches',
            ],
            [
                'name_ar'=>'فن',
                'name_en'=>'Art',
            ],
            [
                'name_ar'=>'رياضة',
                'name_en'=>'Sports',
            ],
            [
                'name_ar'=>'اجهزة منزلية',
                'name_en'=>'Home Appliances',
            ],
            [
                'name_ar'=>'كتب',
                'name_en'=>'Books',
            ],
            [
                'name_ar'=>'العاب',
                'name_en'=>'Toys',
            ],
            [
                'name_ar'=>'مقتنيات نادرة',
                'name_en'=>'Collectibles',
            ],
            [
                'name_ar'=>'معدات موسيقية',
                'name_en'=>'Musical Instruments',
            ],
            [
                'name_ar'=>'ادوات حدائق',
                'name_en'=>'Garden Tools',
            ],
        ]);
    }
}
