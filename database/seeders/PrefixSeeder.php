<?php

namespace Database\Seeders;

use App\Models\Prefix;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefixes = [
            [
                'title' => 'Dr.',
            ],
            [
                'title' => 'Dra.',
            ],
            [
                'title' => 'Ps.',
            ],
            [
                'title' => 'Sr.',
            ],
            [
                'title' => 'Sra.',
            ],
            [
                'title' => 'Mg.',
            ],
            [
                'title' => 'Lic.',
            ],
        ];

        foreach ($prefixes as $prefix) {
            Prefix::create($prefix);
        }
    }
}
