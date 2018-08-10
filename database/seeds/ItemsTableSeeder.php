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
        $faker = \Faker\Factory::create('pl_PL');
        for ($i=0; $i<33; $i++) {
            $item = new Items();
            $item->name = $faker-> colorName;
            $item->price = $faker->randomFloat(2, 1, 100);
            $item->category_id = $faker->numberBetween(1, 6);
            $item->save();
            $item->tags()->attach($faker->numberBetween(1, 6));
            }
        
    }
}
