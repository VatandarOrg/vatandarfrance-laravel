<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'عرفان',
            'last_name' => 'میرزایی',
            'email' => 'erfan.mirzaee8620@gmail.com',
            'password' => Hash::make('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'super-admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
            ]
        ]);

        Permission::insert([
            ['name' => 'crud user', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'admin dashboard', 'guard_name' => 'web', 'created_at' => now()],
        ]);

        DB::table('role_has_permissions')->insert([
            ['role_id' => 2, 'permission_id' => 1],
            ['role_id' => 2, 'permission_id' => 2],
        ]);

        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_id' => 1, 'model_type' => "App\Models\User"],
        ]);
    }
}
