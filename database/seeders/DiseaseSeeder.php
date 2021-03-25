<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diseases = [
            [
                'title' => 'Depresión'
            ],
            [
                'title' => 'Estrés'
            ],
            [
                'title' => 'Trastorno de ansiedad'
            ],
            [
                'title' => 'Ataques de pánico'
            ],
            [
                'title' => 'Trastornos de la personalidad'
            ],
            [
                'title' => 'Ansiedad'
            ],
            [
                'title' => 'Duelo'
            ],
            [
                'title' => 'Trastorno de conducta'
            ],
            [
                'title' => 'Fobia social'
            ],
            [
                'title' => 'Maltrato psicológico y abandono infantil'
            ],
            [
                'title' => 'Trastornos alimentarios'
            ],
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}
