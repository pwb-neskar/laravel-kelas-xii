<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController,
    AuthController,
    KritikController,
    ProfileController,
};
use App\Http\Controllers\Admin\FilmController as AdminFilmController;
use App\Http\Controllers\Admin\CastController as AdminCastController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\PeranController as AdminPeranController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Route film (publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => redirect()->route('home')->with('openLogin', true))
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login.attempt');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register.attempt');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Khusus USER BIASA: kritik/komentar dan profil sendiri
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/movies/{film}/kritik', [KritikController::class, 'store'])->name('kritik.store');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Khusus ADMIN: CRUD film, cast, genre, peran + daftar user
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.films.index'))->name('dashboard');

    Route::resource('films', AdminFilmController::class)->except(['show'])->parameters(['films' => 'film']);
    Route::resource('casts', AdminCastController::class)->except(['show'])->parameters(['casts' => 'cast']);
    Route::resource('genres', AdminGenreController::class)->except(['show'])->parameters(['genres' => 'genre']);
    Route::resource('perans', AdminPeranController::class)->except(['show'])->parameters(['perans' => 'peran']);

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
});