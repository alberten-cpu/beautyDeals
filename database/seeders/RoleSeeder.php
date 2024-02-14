<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role' => 'Admin',
            'roleIdentifier' => 'admin',
            'roleLevel' => 1,
            'status' => true,
        ]);

        Role::create([
            'role' => 'User',
            'roleIdentifier' => 'user',
            'roleLevel' => 2,
            'status' => true,
        ]);

        Role::create([
            'role' => 'EndUser',
            'roleIdentifier' => 'end_user',
            'roleLevel' => 3,
            'status' => true,
        ]);

        Role::create([
            'role' => 'AdminUser',
            'roleIdentifier' => 'admin_user',
            'roleLevel' => 4,
            'status' => true,
        ]);
    }
}
