<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RubroSeeder::class);
        $this->call(ArticuloSeeder::class);
        $this->call(ComprobanteSeeder::class);
        $this->call(ComprobanteDetalleSeeder::class);
    }
}
