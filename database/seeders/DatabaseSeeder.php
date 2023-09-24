<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\HistoriAmi;
use App\Models\Level;
use App\Models\User;
use App\Models\UserHasLevel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $levels = [Level::OPERATOR, Level::KETUA_P4MP, Level::LEAD_AUDITOR, Level::ANGGOTA_AUDITOR, Level::AUDITEE, Level::JURUSAN, Level::OTHERS];

        foreach ($levels as $level) {
            Level::create([
                'name' => $level
            ]);
        }

        $akunOperator = User::factory()->create([
            "nip" => 2003071,
            "password" => bcrypt("password"),
            "foto_profile" => 'images/profile/profile.png'
        ]);

        $historiAmi = HistoriAmi::create([
            "tahun_ami" => "2023/2024",
            "status" => HistoriAmi::ACTIVE
        ]);

        $level = Level::whereName(Level::OPERATOR)->first();

        UserHasLevel::create([
            "user_id" => $akunOperator->id,
            "level_id" => $level->id,
            "histori_ami_id" => $historiAmi->id
        ]);

        $this->call([
            JurusanSeeder::class,
            LayananAkademikSeeder::class
        ]);
    }
}
