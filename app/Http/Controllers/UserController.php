<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest; // Form validation ke liye
use App\Http\Requests\UpdateUserRequest; // Form validation ke liye
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash; // Password hashing ke liye

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View // Return type add karein
    {
        $search = request()->query('search');
        if ($search) {
            $users = User::where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        return view('users.index', compact('users', 'search')); // search variable ko view mein pass karein
    }

    /**
     * Show form to confirm deletion of user resource from storage.
     */
    public function delete(User $user): View
    {
        return view('users.delete', compact('user'));
    }

    /**
     * Return view showing all users in the trash.
     */
    public function trash(): View
    {
        $users = User::onlyTrashed()->latest()->paginate(10);
        return view('users.trash', compact('users'));
    }

    /**
     * Restore user from the trash.
     */
    public function recoverOne($id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect(route('users.trash'))->with('success', 'User restored successfully.');
    }

    /**
     * Permanently remove all users that are in the trash
     */
    public function emptyAll(): RedirectResponse
    {
        User::onlyTrashed()->forceDelete(); // Optimized
        return redirect(route('users.trash'))->with('success', 'Trash emptied successfully.');
    }

    /**
     * Restore all users in the trash to system
     */
    public function recoverAll(): RedirectResponse
    {
        User::onlyTrashed()->restore(); // Optimized
        return redirect(route('users.trash'))->with('success', 'All users restored from trash.');
    }

    /**
     * Permanently remove one user from the trash.
     */
    public function emptyOne($id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect(route('users.trash'))->with('success', 'User permanently deleted from trash.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View // Return type add karein
    {
        return view('users.create'); // create.blade.php view dikhayein
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse // Return type add karein
    {
        // Validation StoreUserRequest mein handle hoga
        $validatedData = $request->validated();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            // 'role' => $validatedData['role'], // Agar 'role' field hai toh
        ]);

        return redirect(route('users.index'))->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View // Return type add karein
    {
        return view('users.show', compact('user')); // show.blade.php view dikhayein
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View // Return type add karein
    {
        return view('users.edit', compact('user')); // edit.blade.php view dikhayein
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse // Return type add karein
    {
        // Validation UpdateUserRequest mein handle hoga
        $validatedData = $request->validated();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        // $user->role = $validatedData['role']; // Agar 'role' field hai toh

        // Agar password update kiya ja raha hai (optional)
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect(route('users.index'))->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete(); // Soft delete
        return redirect(route('users.index'))->with('success', 'User moved to trash successfully.');
    }
}
