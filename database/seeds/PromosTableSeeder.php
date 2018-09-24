<?php

use Illuminate\Database\Seeder;
use App\Promo;

class PromosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
          $faker = \Faker\Factory::create('pl_PL');
        for ($i=0; $i<10; $i++) {
            $promo = new Promo();
            $promo->code = $faker->swiftBicNumber;
            $promo->value = $faker->numberBetween(1, 10);
            $promo->item_id = $faker->numberBetween(1, 14);
            $promo->save();
            $promo->user()->attach($faker->numberBetween(2, 4));
            }            

    }
}
