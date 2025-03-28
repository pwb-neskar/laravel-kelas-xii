<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController, PeranController
};

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

Route::get('/peran/create', [PeranController::class, 'create'])->name('create');
Route::post('/peran', [PeranController::class, 'store'])->name('peran.store');
Route::get('/peran', [PeranController::class, 'index'])->name('peran.index');
Route::get('/show-peran/{id}', [PeranController::class, 'show'])->name('show');
Route::get('/edit-peran/{id}', [PeranController::class, 'edit'])->name('peran.edit');
Route::put('/peran/{id}', [PeranController::class, 'update'])->name('peran.update');
Route::delete('/peran/{id}', [PeranController::class, 'destroy'])->name('peran.destroy');

Route::resource('peran', PeranController::class);


