<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'title' => 'Tarjeta'
            ],
            [
                'title' => 'Efectivo'
            ],
            [
                'title' => 'Paypal'
            ],
            [
                'title' => 'Plin'
            ],
            [
                'title' => 'Yape'
            ],
            [
                'title' => 'Transferencia bancaria'
            ],
            [
                'title' => 'Lukita'
            ],

        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
