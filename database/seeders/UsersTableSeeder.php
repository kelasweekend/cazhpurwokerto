<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        $user->name = "Admin Cazh";
        $user->email = "admin@cazh.id";
        $user->password = bcrypt('cazh2022'); 
        $user->save();
    }
}
