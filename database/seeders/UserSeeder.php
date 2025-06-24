<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedUsers = [
            [
                'name' => 'Santina Deckow',
                'email' => 'tdurgan@example.net',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Reynold Bednar',
                'email' => 'kaela.jacobson@example.com',
                'password' => 'password',
            ],
            [
                'name' => 'Mrs. Stacy Rolfson',
                'email' => 'athena19@example.org',
                'password' => 'password',
            ],
        ];

        foreach ($seedUsers as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
