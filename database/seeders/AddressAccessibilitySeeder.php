<?php

namespace Database\Seeders;

use App\Models\AddressAccessibility;
use Illuminate\Database\Seeder;

class AddressAccessibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessibilities = [
            [
                'title' => 'Con silla de ruedas o muletas'
            ],
            [
                'title' => 'con discapacidad visual'
            ],
            [
                'title' => 'con discapacidad auditiva'
            ],
        ];

        foreach ($accessibilities as $accessibility) {
            AddressAccessibility::create($accessibility);
        }
    }
}
