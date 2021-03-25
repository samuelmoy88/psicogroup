<?php

namespace Database\Seeders;

use App\Models\SecurityMeasures;
use Illuminate\Database\Seeder;

class SecurityMeasuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measures = [
            [
                'title' => 'Los pacientes deben usar obligatoriamente mascarilla y guantes'
            ],
            [
                'title' => 'Únicamente se permiten acompañantes si el paciente es menor de edad'
            ],
            [
                'title' => 'Intervalos más largos entre consultas para evitar contacto entre pacientes'
            ],
            [
                'title' => 'Desinfección y ventilación del consultorio después de cada consulta'
            ],
            [
                'title' => 'Entrevista telefónica con los pacientes sobre posibles síntomas de COVID-19 antes de cada visita'
            ],
            [
                'title' => 'Medición de temperatura a las personas antes de ingresar a la consulta'
            ],
            [
                'title' => 'Productos de desinfección disponibles para los pacientes'
            ],
            [
                'title' => 'Mascarillas disponibles para los pacientes'
            ],
            [
                'title' => 'No hay sala de espera (los pacientes deben esperar afuera)'
            ],
            [
                'title' => 'Limpieza de todas las superficies de la consulta'
            ],
            [
                'title' => 'Desinfección de todas las superficies y objetos que los pacientes puedan tocar'
            ],
            [
                'title' => 'Recepción equipada con mampara de protección'
            ]
        ];

        foreach ($measures as $measure) {
            SecurityMeasures::create($measure);
        }
    }
}
