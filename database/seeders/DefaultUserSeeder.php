<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de usar el modelo correcto

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@artisans.com'], // Reemplaza con el correo deseado
            [
                'name' => 'Admin',
                'password' => bcrypt('leonox97'), // Reemplaza con una contraseña segura
                'email_verified_at' => now(),
            ]
        );
    }
}
