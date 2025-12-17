<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User Pemilik
        User::create([
            'name' => 'Pemilik IKM',
            'email' => 'pemilik@ikm.com',
            'password' => Hash::make('password123'),
            'role' => 'pemilik',
        ]);

        // User Supervisor
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@ikm.com',
            'password' => Hash::make('password123'),
            'role' => 'supervisor',
        ]);
    }
}
