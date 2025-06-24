<?php

namespace Database\Seeders;
use App\Models\Joke;
use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found for JokeSeeder. Please run CategorySeeder first or ensure categories exist.');
            
        }

        Joke::factory()->count(25)->create()->each(function ($joke) use ($categories) {
            if ($categories->isNotEmpty()) {
                
                $joke->categories()->attach(
                    $categories->random(rand(1, min(3, $categories->count())))->pluck('id')->toArray()
                );
            }
        });

        
    }
}