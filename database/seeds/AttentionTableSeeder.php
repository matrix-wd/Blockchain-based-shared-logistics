<?php

use Illuminate\Database\Seeder;

class AttentionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Attention::class, 20)->create();
    }
}
