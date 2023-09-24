<?php

namespace Database\Seeders;

use App\Models\LayananAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = ["Layanan 1", "Layanan 2"];

        foreach ($layanans as $layanan) {
            LayananAkademik::create([
                "nama_layanan" => $layanan
            ]);
        }
    }
}
