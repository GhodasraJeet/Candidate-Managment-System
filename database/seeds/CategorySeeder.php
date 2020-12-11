<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=50;$i++)
        {
            DB::table('category')->insert([
                'name' => Str::random(10),
            ]);
        }
    }
}
