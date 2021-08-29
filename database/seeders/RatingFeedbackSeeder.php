<?php

namespace Database\Seeders;

use App\Models\RatingFeedback;
use Illuminate\Database\Seeder;

class RatingFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ratingFeedback = [
            [
                'title' => 'Da explicaciones detalladas',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Dedicación durante la visita',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Eficacia del tratamiento',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Instalaciones excelentes',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Dedicación durante la visita',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Puntualidad',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Otro',
                'type' => 'positive',
                'status' => 1
            ],
            [
                'title' => 'Falta de comunicación',
                'type' => 'negative',
                'status' => 1
            ],
            [
                'title' => 'Falta de empatía',
                'type' => 'negative',
                'status' => 1
            ],
            [
                'title' => 'La cita fue demasiado corta',
                'type' => 'negative',
                'status' => 1
            ],
            [
                'title' => 'El tratamiento no me convenció',
                'type' => 'negative',
                'status' => 1
            ],
            [
                'title' => 'Retraso en la visita',
                'type' => 'negative',
                'status' => 1
            ],
            [
                'title' => 'Otro',
                'type' => 'negative',
                'status' => 1
            ],
        ];

        foreach ($ratingFeedback as $feedback) {
            RatingFeedback::create($feedback);
        }

    }
}
