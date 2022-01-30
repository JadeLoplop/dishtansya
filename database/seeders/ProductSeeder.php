<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->delete();

        \DB::table('products')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Apple',
                'available_stock' => 100
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Orange',
                'available_stock' => 100
            ),
        ));
    }
}
