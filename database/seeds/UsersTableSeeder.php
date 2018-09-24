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
        $user->name = "Guest";
        $user->email = "guest@guest.com";
        $user->password = bcrypt('guest');
        $user->save();
        
        $user = new User();
        $user->name = "Wiesiek";
        $user->email = "wiesiek@gmail.com";
        $user->password = bcrypt('haslo');
        $user->save();
        $user->roles()->attach(1);
        
        $user = new User();
        $user->name = "Jon";
        $user->email = "jonus@gmail.com";
        $user->password = bcrypt('asd123');
        $user->save();
        $user->roles()->attach(2);
        
          $user = new User();
        $user->name = "Mojo Jojo";
        $user->email = "mojojojo@gmail.com";
        $user->password = bcrypt('asd123');
        $user->save();
        $user->roles()->attach(3);
    }
}
