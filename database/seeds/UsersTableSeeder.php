<?php

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
        User::create([
            'name' => 'Man Phan',
            'email' => 'phandinhman@gmail.com',
            'password' => bcrypt('123123'),
        ]);
    }
}
