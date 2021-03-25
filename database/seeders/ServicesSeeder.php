<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'title' => 'Consulta online'
            ],
            [
                'title' => 'Consulta presencial'
            ],
            [
                'title' => 'Primera visita psicología'
            ],
            [
                'title' => 'Visitas psicológicas sucesivas'
            ],
        ];

        foreach ($services as $service) {
            Services::create($service);
        }
    }
}
