<?php

use Illuminate\Database\Seeder;
use App\Comprobante;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comprobante::class, 30)->create();
    }
}