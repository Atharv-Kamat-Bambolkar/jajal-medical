<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@jajalmedical.test'],
            [
                'name' => 'Jajal Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'Admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'viewer@jajalmedical.test'],
            [
                'name' => 'Jajal Viewer',
                'password' => Hash::make('Viewer@12345'),
                'role' => 'Viewer',
            ]
        );

        $this->call(MedicalCaseSeeder::class);
    }
}
