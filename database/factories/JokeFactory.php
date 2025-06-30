<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joke>
 */
class JokeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $jokes = [
        ['title' => 'The Past, Present, and Future', 'body' => 'The past, the present, and the future walk into a bar. It was tense.'],
        ['title' => 'A Dyslexic Man', 'body' => 'A dyslexic man walks into a bra.'],
        ['title' => 'Helvetica and Times New Roman', 'body' => 'Helvetica and Times New Roman walk into a bar. “Get out of here!” shouts the bartender. “We don’t serve your type.”'],
        ['title' => 'A Man and His Giraffe', 'body' => 'A man takes his giraffe to the bar. The giraffe has a few too many and passes out. The man gets up to leave, and the bartender says, “Hey, you can’t leave that lyin’ here!” The man says, “That’s not a lion, it’s a giraffe.”'],
        ['title' => 'Why don\'t scientists trust atoms?', 'body' => 'Because they make up everything!'],
        ['title' => 'What do you call a fake noodle?', 'body' => 'An Impasta.'],
        ['title' => 'I would avoid the sushi if I was you.', 'body' => 'It’s a little fishy.'],
        ['title' => 'Want to hear a joke about paper?', 'body' => 'Nevermind, it’s tearable.'],
        ['title' => 'What do you call a poor Santa Claus?', 'body' => 'St. Nickel-less.'],
        ['title' => 'I\'m reading a book on anti-gravity.', 'body' => 'It’s impossible to put down!'],
    ];

    public function definition(): array
    {
        $joke = $this->faker->randomElement(self::$jokes);

        return [
            'user_id' => User::factory(), 
            'title' => $joke['title'],
            'body' => $joke['body'],
        ];
    }
}
