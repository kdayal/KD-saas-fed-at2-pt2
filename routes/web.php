<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;

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
Route::get('/pricing', [StaticPagesController::class, 'pricing'])->name('pricing');

// Dashboard route, requires authentication and email verification
Route::get('/dashboard', function () {
    return view('static.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User BREAD/CRUD routes
    Route::resource('users', UserController::class);
    Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete'); 

    //Trash Routes//
    Route::get('users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::patch('users/trash/{id}/recover', [UserController::class, 'recoverOne'])->name('users.recover-one');
    Route::delete('users/trash/empty', [UserController::class, 'emptyAll'])->name('users.empty-all');
    Route::delete('users/trash/{id}/empty-one', [UserController::class, 'emptyOne'])->name('users.empty-one');
    Route::patch('users/trash/recover-all', [UserController::class, 'recoverAll'])->name('users.recover-all');

});

// Include authentication routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';
