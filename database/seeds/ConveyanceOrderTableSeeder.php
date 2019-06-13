<?php

use Illuminate\Database\Seeder;

class ConveyanceOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ConveyanceOrder::class, 50)->create();
    }
}
