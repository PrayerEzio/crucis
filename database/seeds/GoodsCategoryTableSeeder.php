<?php

use Illuminate\Database\Seeder;

class GoodsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Http\Models\GoodsCategory::class, 10)->create();
    }
}
