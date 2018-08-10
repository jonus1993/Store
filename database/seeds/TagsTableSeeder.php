<?php

use Illuminate\Database\Seeder;
use App\Tags;

class TagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tag = new Tags();
        $name = "Nowość";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();

        $tag = new Tags();
        $name = "Wyprzedaż";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();

        $tag = new Tags();
        $name = "Końcówki serii!";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();

        $tag = new Tags();
        $name = "Best-Seller";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();

        $tag = new Tags();
        $name = "Promocja";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();

        $tag = new Tags();
        $name = "Kup 3 zapłać za 2";
        $tag->name = $name;
        $tag->friend_name = str_slug($name);
        $tag->save();
    }

}
