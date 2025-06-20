<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use App\Http\Requests\StoreJokeRequest;
use App\Http\Requests\UpdateJokeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Category; 

class JokeController extends Controller
{
    /**
     * Display a listing of the jokes.
     */
    public function index(Request $request): View
    {
        $query = Joke::with(['user', 'categories'])->latest();

        if ($request->filled('search_term')) { 
            $searchTerm = $request->input('search_term');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('body', 'LIKE', "%{$searchTerm}%"); 
            });
        }

        if ($request->filled('category_search')) { 
            $categorySearchId = $request->input('category_search');
            if (!empty($categorySearchId)) {
                $query->whereHas('categories', function ($q) use ($categorySearchId) {
                    $q->where('categories.id', $categorySearchId);
                });
            }
        }

        $jokes = $query->paginate(10);
        $categories = Category::orderBy('name')->get(); 

        return view('jokes.index', compact('jokes', 'categories'));
    }

    /**
     * Show the form for creating a new joke.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get(); 
        return view('jokes.create', compact('categories'));
    }

    /**
     * Store a newly created joke in storage.
     */
    public function store(StoreJokeRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        
        $joke = Joke::create($validatedData);

       
        if ($request->has('categories')) {
            $joke->categories()->attach($request->input('categories'));
        }

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
        $categories = Category::orderBy('name')->get(); // Sabhi categories
        $jokeCategoryIds = $joke->categories->pluck('id')->toArray(); // Joke ki current categories
        return view('jokes.edit', compact('joke', 'categories', 'jokeCategoryIds'));
    }

    /**
     * Update the specified joke in storage.
     */
    public function update(UpdateJokeRequest $request, Joke $joke): RedirectResponse
    {
        $this->authorize('update', $joke);
        $joke->update($request->validated());

        // Categories ko sync karein
        if ($request->has('categories')) {
            $joke->categories()->sync($request->input('categories'));
        } else {
            $joke->categories()->detach(); 
        }

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

    /**
     * Permanently remove all soft-deleted jokes from storage.
     */
    public function emptyAll(): RedirectResponse
    {
        Joke::onlyTrashed()->forceDelete();
        return redirect(route('jokes.trash'))->with('success', 'Trash emptied successfully.');
    }
}
