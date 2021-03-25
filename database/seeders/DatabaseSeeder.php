<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PrefixSeeder::class,
            SpecialitySeeder::class,
            DiseaseSeeder::class,
            SecurityMeasuresSeeder::class,
            AddressAccessibilitySeeder::class,
            InsuranceSupportSeeder::class,
            PaymentMethodSeeder::class,
            ServicesSeeder::class,
        ]);
    }
}
