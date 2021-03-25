<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialities = [
            [
                'title' => 'Terapia Familiar'
            ],
            [
                'title' => 'Terapia de pareja'
            ],
            [
                'title' => 'Coaching'
            ],
            [
                'title' => 'Psicooncología'
            ],
            [
                'title' => 'Neuropsicología'
            ],
            [
                'title' => 'Evaluaciones'
            ],
            [
                'title' => 'Trastornos del espectro autista'
            ],
            [
                'title' => 'Orientación vocacional'
            ],
            [
                'title' => 'Psicoanálisis'
            ],
            [
                'title' => 'Psicoterapia EMDR'
            ],
            [
                'title' => 'Terapia sexual'
            ],
            [
                'title' => 'Mindfulness'
            ],
            [
                'title' => 'Tratamiento para la ansiedad'
            ],
            [
                'title' => 'Tratamiento para la depresión'
            ],
            [
                'title' => 'Tratamiento online'
            ],
            [
                'title' => 'Psicoterapia individual'
            ],
            [
                'title' => 'Psicología de la educación'
            ],
            [
                'title' => 'Psicología del deporte'
            ],
            [
                'title' => 'Psicología forense'
            ],
        ];

        foreach ($specialities as $speciality) {
            Speciality::create($speciality);
        }
    }
}
