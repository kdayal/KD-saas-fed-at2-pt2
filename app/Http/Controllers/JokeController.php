<?php

namespace App\Http\Controllers; 

use App\Models\Joke;
use App\Http\Requests\StoreJokeRequest;
use App\Http\Requests\UpdateJokeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JokeController extends Controller
{
    
    public function index(Request $request): View
    {
        $query = Joke::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn($q) => $q->where('title', 'LIKE', "%{$search}%")
                                      ->orWhere('content', 'LIKE', "%{$search}%")
                                      ->orWhere('category', 'LIKE', "%{$search}%"));
        }
        $jokes = $query->paginate(10);
        return view('jokes.index', compact('jokes'));
    }

    /**
     * Show the form for creating a new joke.
     */
    public function create(): View
    {
        return view('jokes.create');
    }

    /**
     * Store a newly created joke in storage.
     */
    public function store(StoreJokeRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        Joke::create($validatedData);
        return redirect(route('jokes.index'))->with('success', 'Joke created successfully.');
    }

    /**
     * Display the specified joke.
     */
    public function show(Joke $joke): View
    {
        return view('jokes.show', compact('joke'));
    }

    /**
     * Show the form for editing the specified joke.
     */
    public function edit(Joke $joke): View
    {
        $this->authorize('update', $joke);
        return view('jokes.edit', compact('joke'));
    }

    /**
     * Update the specified joke in storage.
     */
    public function update(UpdateJokeRequest $request, Joke $joke): RedirectResponse
    {
        $this->authorize('update', $joke);
        $joke->update($request->validated());
        return redirect(route('jokes.index'))->with('success', 'Joke updated successfully.');
    }

    /**
     * Show the form to confirm deletion of the specified joke.
     */
    public function delete(Joke $joke): View
    {
        $this->authorize('delete', $joke);
        return view('jokes.delete', compact('joke'));
    }

    /**
     * Remove the specified joke from storage (soft delete).
     */
    public function destroy(Joke $joke): RedirectResponse
    {
        $this->authorize('delete', $joke);
        $joke->delete();
        return redirect(route('jokes.index'))->with('success', 'Joke moved to trash.');
    }

    /**
     * Display a listing of soft-deleted jokes.
     */
    public function trash(): View
    {
        $jokes = Joke::onlyTrashed()->with('user')->latest()->paginate(10);
        return view('jokes.trash', compact('jokes'));
    }

    /**
     * Restore the specified soft-deleted joke.
     * @param int $id The ID of the trashed joke
     */
    public function recoverOne($id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);
        // $this->authorize('restore', $joke); // Optional: Policy check
        $joke->restore();
        return redirect(route('jokes.trash'))->with('success', 'Joke restored successfully.');
    }

    /**
     * Permanently remove the specified soft-deleted joke from storage.
     * @param int $id The ID of the trashed joke
     */
    public function emptyOne($id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);
        // $this->authorize('forceDelete', $joke); // Optional: Policy check
        $joke->forceDelete();
        return redirect(route('jokes.trash'))->with('success', 'Joke permanently deleted.');
    }

    /**
     * Restore all soft-deleted jokes.
     */
    public function recoverAll(): RedirectResponse
    {
        Joke::onlyTrashed()->restore();
        return redirect(route('jokes.trash'))->with('success', 'All jokes restored from trash.');
    }

    
    public function emptyAll(): RedirectResponse
    {
        Joke::onlyTrashed()->forceDelete();
        return redirect(route('jokes.trash'))->with('success', 'Trash emptied successfully.');
    }
}
