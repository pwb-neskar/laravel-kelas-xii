<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'Film'   => ['total' => Film::count(),   'icon' => 'fa-film',     'route' => 'admin.films.index',   'color' => 'primary'],
            'Genre'  => ['total' => Genre::count(),  'icon' => 'fa-tags',     'route' => 'admin.genres.index',  'color' => 'success'],
            'Cast'   => ['total' => Cast::count(),   'icon' => 'fa-users',    'route' => 'admin.casts.index',   'color' => 'info'],
            'Peran'  => ['total' => Peran::count(),  'icon' => 'fa-id-badge', 'route' => 'admin.perans.index',  'color' => 'warning'],
            'Kritik' => ['total' => Kritik::count(), 'icon' => 'fa-comments', 'route' => 'admin.kritiks.index', 'color' => 'danger'],
            'User'   => ['total' => User::count(),   'icon' => 'fa-user',     'route' => 'admin.users.index',   'color' => 'default'],
        ];

        $latestFilms   = Film::with('genre:id,name')->latest('id')->limit(5)->get();
        $latestKritiks = Kritik::with(['film:id,title', 'user:id,name'])->latest('id')->limit(5)->get();
        $genres        = Genre::withCount('films')->orderByDesc('films_count')->get();

        return view('admin.dashboard', compact('stats', 'latestFilms', 'latestKritiks', 'genres'));
    }
}
