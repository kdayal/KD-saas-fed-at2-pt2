<?php
use App\Http\Controllers\JokeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\JokeInteractionController;
use App\Http\Controllers\Admin\CategoryController;

use App\Models\Category; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
|
*/

// Publicly accessible static page routes
Route::get('/', [StaticPagesController::class, 'welcome'])->name('home');
Route::get('/welcome', [StaticPagesController::class, 'welcome'])->name('welcome.explicit');
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');
Route::get('/contact-us', [StaticPagesController::class, 'contactUs'])->name('contact-us');
Route::get('/privacy', [StaticPagesController::class, 'privacy'])->name('privacy');
Route::get('/pricing', [StaticPagesController::class, 'pricing'])->name('pricing');

// Authenticated user routes
    Route::middleware('auth')->group(function () {

    // Dashboard route, requires authentication and email verification
    Route::get('/dashboard', function () {
            $categoryCount = Category::count(); 
        return view('static.dashboard' ,  compact('categoryCount'));
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::prefix('jokes/trash')->name('jokes.')->group(function () {
        Route::get('/', [JokeController::class, 'trash'])->name('trash');
    });
    
    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Joke Interaction Route
    Route::post('/jokes/{joke}/interact', [JokeInteractionController::class, 'store'])->name('jokes.interact');

    // --- Roles & Permissions Admin Routes ---
    // These routes are only for users with 'Administrator' role or 'Roles & Permissions' permission
    Route::middleware(['roleOrPermission:Administrator,Roles & Permissions'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
        
    }); // <-- THIS GROUP SHOULD CLOSE HERE

    // User BREAD/CRUD routes
    // Protection for these routes will be handled in UserController or policies
    Route::resource('users', UserController::class);
    Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

    //User Trash Routes
    Route::get('users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::patch('users/trash/{id}/recover', [UserController::class, 'recoverOne'])->name('users.recover-one');
    Route::delete('users/trash/empty', [UserController::class, 'emptyAll'])->name('users.empty-all');
    Route::delete('users/trash/{id}/empty-one', [UserController::class, 'emptyOne'])->name('users.empty-one');
    Route::patch('users/trash/recover-all', [UserController::class, 'recoverAll'])->name('users.recover-all');

    // Joke BREAD/CRUD routes
    // Protection for these routes will be handled in JokeController or policies
    Route::resource('jokes', JokeController::class);
    Route::get('jokes/{joke}/delete', [JokeController::class, 'delete'])->name('jokes.delete'); // For delete confirmation page

    // Joke Trash Routes
    Route::prefix('jokes/trash')->name('jokes.')->group(function () {
        Route::get('/', [JokeController::class, 'trash'])->name('trash');
        Route::patch('/{id}/recover', [JokeController::class, 'recoverOne'])->name('recover-one');
        Route::delete('/{id}/empty-one', [JokeController::class, 'emptyOne'])->name('empty-one');
        Route::patch('/recover-all', [JokeController::class, 'recoverAll'])->name('recover-all');
        Route::delete('/empty', [JokeController::class, 'emptyAll'])->name('empty-all');
    });

}); // Main 'auth' group closes here

// Include authentication routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';
