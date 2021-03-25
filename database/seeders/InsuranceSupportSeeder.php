<?php

namespace Database\Seeders;

use App\Models\InsuranceSupport;
use Illuminate\Database\Seeder;

class InsuranceSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insuranceSupports = [
            [
                'title' => 'Solo pacientes privados'
            ],
            [
                'title' => 'Solo seguros'
            ],
            [
                'title' => 'Seguros y pacientes privados'
            ],
        ];

        foreach ($insuranceSupports as $support) {
            InsuranceSupport::create($support);
        }
    }
}
