<?php

use Illuminate\Database\Seeder;
use App\Categories;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        
            $category = new Categories();
            $category->name = 'darks';
            $category->save();
            
            $category = new Categories();
            $category->name = 'lights';
            $category->save();
            
            $category = new Categories();
            $category->name = 'reds';
            $category->save();
            
            $category = new Categories();
            $category->name = 'blues';
            $category->save();
            
            $category = new Categories();
            $category->name = 'yellows';
            $category->save();
            
            $category = new Categories();
            $category->name = 'grays';
            $category->save();
    }
}
