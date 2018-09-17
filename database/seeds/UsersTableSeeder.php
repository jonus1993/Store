<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Wiesiek";
        $user->email = "wiesiek@gmail.com";
        $user->password = bcrypt('haslo');
        $user->save();
        $user->roles()->attach(1);
    }
}
