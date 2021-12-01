<?php

namespace Database\Seeders;

use App\Models\EducationDegree;
use Illuminate\Database\Seeder;

class EducationDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = [
            [
                'name' => 'Bachiller',
                'order' => 1,
            ],
            [
                'name' => 'Licenciatura',
                'order' => 2,
            ],
            [
                'name' => 'Magister',
                'order' => 3,
            ],
            [
                'name' => 'Doctorado',
                'order' => 4,
            ],
            [
                'name' => 'Ph. D.',
                'order' => 5,
            ],
        ];

        foreach ($degrees as $degree) {
            EducationDegree::create($degree);
        }
    }
}
