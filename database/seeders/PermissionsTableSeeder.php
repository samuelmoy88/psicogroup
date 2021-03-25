<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Doctors
            ['name' => 'doctors_read'],
            ['name' => 'doctors_create'],
            ['name' => 'doctors_update'],
            ['name' => 'doctors_delete'],
            // Patients
            ['name' => 'patients_read'],
            ['name' => 'patients_create'],
            ['name' => 'patients_update'],
            ['name' => 'patients_delete'],
            // Services
            ['name' => 'services_read'],
            ['name' => 'services_create'],
            ['name' => 'services_update'],
            ['name' => 'services_delete'],
            // Specialities
            ['name' => 'specialities_read'],
            ['name' => 'specialities_create'],
            ['name' => 'specialities_update'],
            ['name' => 'specialities_delete'],
            // Diseases
            ['name' => 'diseases_read'],
            ['name' => 'diseases_create'],
            ['name' => 'diseases_update'],
            ['name' => 'diseases_delete'],
            // Payment methods
            ['name' => 'payment_methods_read'],
            ['name' => 'payment_methods_create'],
            ['name' => 'payment_methods_update'],
            ['name' => 'payment_methods_delete'],
            // Security measures
            ['name' => 'security_measures_read'],
            ['name' => 'security_measures_create'],
            ['name' => 'security_measures_update'],
            ['name' => 'security_measures_delete'],
            // Users
            ['name' => 'users_read'],
            ['name' => 'users_create'],
            ['name' => 'users_update'],
            ['name' => 'users_delete'],
            // Roles
            ['name' => 'roles_read'],
            ['name' => 'roles_create'],
            ['name' => 'roles_update'],
            ['name' => 'roles_delete'],
            // Permissions
            ['name' => 'permissions_read'],
            ['name' => 'permissions_create'],
            ['name' => 'permissions_update'],
            ['name' => 'permissions_delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
