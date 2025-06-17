<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use App\Models\JokeInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class JokeInteractionController extends Controller
{
    public function __construct()
    {
        // Ensure only authenticated users can interact
        $this->middleware('auth');
    }

    public function store(Request $request, Joke $joke): RedirectResponse
    {
        $request->validate([
            'interaction_type' => 'required|in:like,dislike',
        ]);

        $userId = Auth::id();
        $interactionType = $request->input('interaction_type');

        // Find existing interaction by this user for this joke
        $existingInteraction = JokeInteraction::where('user_id', $userId)
                                              ->where('joke_id', $joke->id)
                                              ->first();

        if ($existingInteraction) {
            // If the user clicks the same button again (e.g., clicks 'like' when already liked)
            if ($existingInteraction->type === $interactionType) {
                $existingInteraction->delete(); // Remove the interaction (unlike/undislike)
                $message = ucfirst($interactionType) . ' removed.';
            } else {
                // If the user changes their mind (e.g., clicks 'dislike' when already liked)
                $existingInteraction->type = $interactionType;
                $existingInteraction->save();
                $message = 'Interaction changed to ' . $interactionType . '.';
            }
        } else {
            // No existing interaction, create a new one
            JokeInteraction::create([
                'user_id' => $userId,
                'joke_id' => $joke->id,
                'type' => $interactionType,
            ]);
            $message = 'Joke ' . $interactionType . 'd.';
        }

        return back()->with('success', $message);
    }
}
