<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'nom' => 'Administrateur',
            'prenom' => 'Système',
            'username' => 'admin',
            'email' => 'admin@blog.local',
            'password' => bcrypt('1234'),
            'role' => 'administrateur',
            'statut' => true,
        ]);
    }
}
