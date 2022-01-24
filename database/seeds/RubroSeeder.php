<?php

use Illuminate\Database\Seeder;
use App\Rubro;

class RubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rubro::class, 10)->create();
    }
}