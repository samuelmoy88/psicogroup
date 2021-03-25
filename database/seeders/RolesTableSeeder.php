<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'super admin'],
            ['name' => 'moderator'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

    }
}
