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
        $query = Joke::with('user')->latest(); // Eager load user

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn($q) => $q->where('title', 'LIKE', "%{$search}%")
                                      ->orWhere('content', 'LIKE', "%{$search}%")
                                      ->orWhere('category', 'LIKE', "%{$search}%"));
        }
        $jokes = $query->paginate(10);
        return view('jokes.index', compact('jokes'));
    }

    public function create(): View
    {
        return view('jokes.create');
    }

    public function store(StoreJokeRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        Joke::create($validatedData);
        return redirect(route('jokes.index'))->with('success', 'Joke created successfully.');
    }

    public function show(Joke $joke): View
    {
        return view('jokes.show', compact('joke'));
    }

    public function edit(Joke $joke): View
    {
        // $this->authorize('update', $joke); // Using JokePolicy
        return view('jokes.edit', compact('joke'));
    }

    public function update(UpdateJokeRequest $request, Joke $joke): RedirectResponse
    {
        // $this->authorize('update', $joke); // Using JokePolicy
        $joke->update($request->validated());
        return redirect(route('jokes.index'))->with('success', 'Joke updated successfully.');
    }

    public function delete(Joke $joke): View
    {
        // $this->authorize('delete', $joke); // Using JokePolicy
        return view('jokes.delete', compact('joke'));
    }

    public function destroy(Joke $joke): RedirectResponse
    {
        // $this->authorize('delete', $joke); // Using JokePolicy
        $joke->delete();
        return redirect(route('jokes.index'))->with('success', 'Joke moved to trash.');
    }

    // Trash Methods
    public function trash(): View
    {
        $jokes = Joke::onlyTrashed()->with('user')->latest()->paginate(10);
        return view('jokes.trash', compact('jokes'));
    }

    public function recoverOne($id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);
        // $this->authorize('restore', $joke); // Using JokePolicy
        $joke->restore();
        return redirect(route('jokes.trash'))->with('success', 'Joke restored.');
    }

    public function emptyOne($id): RedirectResponse
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);
        // $this->authorize('forceDelete', $joke); // Using JokePolicy
        $joke->forceDelete();
        return redirect(route('jokes.trash'))->with('success', 'Joke permanently deleted.');
    }

    public function recoverAll(): RedirectResponse
    {
        // Consider authorization for bulk actions
        Joke::onlyTrashed()->restore();
        return redirect(route('jokes.trash'))->with('success', 'All jokes restored.');
    }

    public function emptyAll(): RedirectResponse
    {
        // Consider authorization for bulk actions
        Joke::onlyTrashed()->forceDelete();
        return redirect(route('jokes.trash'))->with('success', 'Trash emptied.');
    }
}
