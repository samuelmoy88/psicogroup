<?php

namespace Database\Seeders;

use App\Models\PaymentFrequency;
use Illuminate\Database\Seeder;

class PaymentFrequenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frequencies = [
            [
                'label' => 'Anual',
                'frequency' => 'yearly',
                'coefficient' => 1,
            ],
            [
                'label' => 'Semestral',
                'frequency' => 'biannual',
                'coefficient' => 2,
            ],
            [
                'label' => 'Trimestral',
                'frequency' => 'quarterly',
                'coefficient' => 4,
            ],
            [
                'label' => 'Mensual',
                'frequency' => 'monthly',
                'coefficient' => 12,
            ],
        ];

        foreach ($frequencies as $frequency) {
            PaymentFreqPuency::create($frequency);
        }
    }
}
