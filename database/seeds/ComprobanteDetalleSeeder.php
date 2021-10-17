<?php

use Illuminate\Database\Seeder;
use App\ComprobanteDetalle;

class ComprobanteDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ComprobanteDetalle::class, 20)->create();
    }
}
