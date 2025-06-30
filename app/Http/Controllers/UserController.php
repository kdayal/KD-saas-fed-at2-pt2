<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View // Add return type
    {
        $search = request()->query('search');
            $query = User::query()->with('roles'); 
        if ($search) {
            $users = User::where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        return view('users.index', compact('users', 'search')); // Pass search variable to the view
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
    public function create(): View // Add return type
    {
        $this->authorize('create', User::class);
        // Fetch roles that can be assigned. Exclude 'Administrator' to prevent creating new admins.
        $roles = Role::where('name', '!=', 'Administrator')->pluck('name', 'name');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        // Validation will be handled in StoreUserRequest
        $validatedData = $request->validated();

        // Construct the full name from given and family names
        $user = User::create([
            'name' => $validatedData['given_name'] . ' ' . $validatedData['family_name'],
            'given_name' => $validatedData['given_name'],
            'family_name' => $validatedData['family_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Assign the selected role
        $user->assignRole($validatedData['role']);

        return redirect(route('users.index'))->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View // Add return type
    {
        return view('users.show', compact('user')); // Show show.blade.php view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get(); 
        $userRoles = $user->roles->pluck('name')->toArray(); 
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse // Add return type
    {
        // Validation will be handled in UpdateUserRequest
        $validatedData = $request->validated();

        $user->given_name = $validatedData['given_name'];
        $user->family_name = $validatedData['family_name'];
        $user->name = $validatedData['given_name'] . ' ' . $validatedData['family_name'];
        $user->email = $validatedData['email'];

        // If password is being updated (optional)
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();
        if ($request->has('roles')) {
            $user->syncRoles($request->roles); // Method from Spatie package
        } else {
            $user->syncRoles([]); // If no role is selected, remove all roles
        }

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
