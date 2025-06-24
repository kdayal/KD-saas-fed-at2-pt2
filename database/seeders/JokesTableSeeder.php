<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Joke;
use App\Models\Category;
use App\Models\User;

class JokesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');

        $seedJokes = [
            [
                'title' => "Skeleton Fight",
                'body' => "Why don't skeletons fight each other? They don't have the guts.",
                'category' => ['pirate'],
            ],
            [
                'title' => "Parallel Lines",
                'body' => "Parallel lines have so much in common. It's a shame they'll never meet.",
                'category' => ['maths'],
            ],
            [
                'title' => "Embracing Mistakes",
                'body' => "I told my wife she should embrace her mistakes. She gave me a hug.",
                'category' => ['one-liner'],
            ],
            [
                'title' => "Broken Pencil",
                'body' => "I was going to tell a joke about a broken pencil, but it was pointless.",
                'category' => ['one-liner'],
            ],
            [
                'title' => "Light Sleeper",
                'body' => "I told my wife she should stop sleeping in the fridge. She said she's just a light sleeper.",
                'category' => ['one-liner'],
            ],
            [
                'title' => "Elevator Business",
                'body' => "I'm thinking of starting a business installing elevators. I hear it has its ups and downs.",
                'category' => ['one-liner'],
            ],
            [
                'title' => 'What is a pirate’s',
                'body' => 'What is a pirate’s favourite element? Arrrrrrrrgon',
                'category' => ['science', 'pirate']
            ],
            [
                'title' => 'Why did the amoeba fail the',
                'body' => 'Why did the amoeba fail the Maths class? Because it multiplied by dividing.',
                'category' => ['science']
            ],
            [
                'title' => 'Why did the physicist break up',
                'body' => 'Why did the physicist break up with the biologist? Because there was no chemistry.',
                'category' => ['science']
            ],
            [
                'title' => 'What did the mum say to',
                'body' => 'What did the mum say to their messy kid? I have a black belt in laundry.',
                'category' => ['mum', 'kids']
            ],
            [
                'title' => 'What did the toddler say to',
                'body' => 'What did the toddler say to the tired mum? Naptime for you, not me.',
                'category' => ['mum', 'kids']
            ],
            [
                'title' => 'What did the ocean say to',
                'body' => 'What did the ocean say to the pirate? Nothing. It just waved.',
                'category' => ['pirate']
            ],
            [
                'title' => 'What is a pirate’s',
                'body' => 'What is a pirate’s least favourite vegetable? Leeks.',
                'category' => ['food', 'pirate']
            ],
            [
                'title' => 'I used to be a baker',
                'body' => 'I used to be a baker… but I could not make enough dough.',
                'category' => ['food', 'puns']
            ],
            [
                'title' => 'What types of maths are pirates',
                'body' => 'What types of maths are pirates best at? Algebra, because they are good at finding X.',
                'category' => ['pirate', 'maths']
            ],
        ];

        foreach ($seedJokes as $jokeData) {
            $categories = $jokeData['category'];
            unset($jokeData['category']);

            $joke = Joke::create([
                'user_id' => $userIds->random(),
                'title' => $jokeData['title'],
                'body' => $jokeData['body']
            ]);

            // attach categories
            foreach ($categories as $catName) {
                $category = Category::where('name', strtolower($catName))->first();
                if ($category) {
                    $joke->categories()->attach($category->id);
                }
            }
        }
    }
}
