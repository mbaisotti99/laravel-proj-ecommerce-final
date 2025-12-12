<?php

namespace Database\Seeders;

use App\Models\Ship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ships = ["Spedizione Standard" => 7, "Spedizione Standard + TRACK" => 10, "Spedizione Espresso" => 15];

        foreach ($ships as $ship => $cost) {
            Ship::firstOrCreate(
                ['nome' => $ship],
                ['costo' => $cost]
            );
        }
    }
}
