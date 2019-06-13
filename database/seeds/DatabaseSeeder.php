<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(StorageTableSeeder::class);
        $this->call(GoodsTableSeeder::class);
        $this->call(ConveyanceTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
        $this->call(TransportTableSeeder::class);
        $this->call(OrderTableSeeder::class);
    }
}