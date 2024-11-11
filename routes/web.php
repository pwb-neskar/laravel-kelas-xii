<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController,
    KritikController,
    AuthController,
    UserController,
    RegisterController,
    SearchController,

};

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Resource route for film (if you're using CRUD actions)
//tambah route

Route::resource('film', FilmController::class)->parameters([
    'film' => 'film'
]);

Route::get('/search', [SearchController::class, 'search'])->name('film.search');

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create');
    Route::post('/register', 'store')->name('register.store');
});

Route::resource('users', UserController::class)->middleware('can:manage_users');

Route::controller(AuthController::class)->group(function () {
    Route::post('authenticate', 'authenticate')->name('login.authenticate');
    Route::post('logout', 'logout')->name('login.logout');
});