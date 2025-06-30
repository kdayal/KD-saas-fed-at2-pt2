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
                'given_name' => 'Santina',
                'family_name' => 'Deckow',
                'email' => 'tdurgan@example.net',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Reynold Bednar',
                'given_name' => 'Reynold',
                'family_name' => 'Bednar',
                'email' => 'kaela.jacobson@example.com',
                'password' => 'password',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Mrs. Stacy Rolfson',
                'given_name' => 'Stacy',
                'family_name' => 'Rolfson',
                'email' => 'athena19@example.org',
                'password' => 'password',
                'email_verified_at' => null,
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
