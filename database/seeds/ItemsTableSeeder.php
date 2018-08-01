<?php

use Illuminate\Database\Seeder;
use App\Items;
class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i<100; $i++) {
            $items = new Items();
            $items->name = $faker->colorName;
            $items->price = $faker->numberBetween(0, 1100);
            $items->save();
            }
        
    }
}
