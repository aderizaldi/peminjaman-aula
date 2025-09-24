<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => UserRole::ADMIN]);
        $operatorRole = Role::firstOrCreate(['name' => UserRole::OPERATOR]);
        $userRole = Role::firstOrCreate(['name' => UserRole::USER]);

        // Create users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345'),
        ]);
        $admin->assignRole($adminRole);

        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@example.com',
            'password' => bcrypt('12345'),
        ]);
        $operator->assignRole($operatorRole);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('12345'),
        ]);
        $user->assignRole($userRole);
    }
}
