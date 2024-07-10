<?php

namespace Database\Seeders;

use App\Models\Data\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periode::create([
            'tahun_ajaran' => '2024-2025',
            'semester' => 'Ganjil',
            'periode_status' => true,
        ]);
        Periode::create([
            'tahun_ajaran' => '2024-2025',
            'semester' => 'Genap',
        ]);
        Periode::create([
            'tahun_ajaran' => '2025-2026',
            'semester' => 'Ganjil',
        ]);
        Periode::create([
            'tahun_ajaran' => '2025-2026',
            'semester' => 'Genap',
        ]);
    }
}
