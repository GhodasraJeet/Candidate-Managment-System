<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;
        // factory(User::class, $count)->create();
        DB::table('users')->insert([
            'name'=>'jeet',
            'email'=>'jeet@gmail.com',
            'password'=>bcrypt('12345678'),
            'role'=>'admin'
        ]);
    }
}
