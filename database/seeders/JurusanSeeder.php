<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = ["Teknik Informatika", "Teknik Mesin", "Teknik Pendingin dan Tata Udara", "Keperawatan"];

        $prodis["Teknik Informatika"] = ["Teknik Informatika", "Rekayasa Perangkat Lunak", "Sistem Informasi Kota Cerdas"];
        $prodis["Teknik Mesin"] = ["Teknik Mesin", "Perancangan Manufaktur"];
        $prodis["Teknik Pendingin dan Tata Udara"] = ["Teknik Pendingin dan Tata Udara"];
        $prodis["Keperawatan"] = ["Keperawatan"];

        foreach ($jurusans as $jurusan) {
            $jurusan = Jurusan::create([
                "nama_jurusan" => $jurusan
            ]);

            if ($prodis[$jurusan->nama_jurusan]) {
                foreach ($prodis[$jurusan->nama_jurusan] as $prodi) {
                    $jurusan->prodi()->create([
                        "nama_prodi" => $prodi
                    ]);
                }
            }
        }
    }
}
