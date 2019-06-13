<?php

use Illuminate\Database\Seeder;

class ConveyanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Conveyance::class, 30)->create();
    }
}
