<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /* =====================================================
     |  HALAMAN PUBLIK
     ===================================================== */

    public function movieHome()
    {
        $films = Film::select('id', 'title', 'poster', 'year')
            ->orderBy('created_at', 'asc')
            ->limit(9)->get();

        $filmFutured = Film::select('id', 'title', 'poster', 'year')
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->limit(6)->get();

        $filmRecentAdded = Film::select('id', 'title', 'poster', 'year')
            ->latest('id')
            ->limit(6)->get();

        $filmSlidey = Film::select('title', 'poster', 'sinopsis')
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->limit(6)->get();

        return view('components/home', compact('filmSlidey', 'films', 'filmFutured', 'filmRecentAdded'));
    }

    public function movies(Request $request)
    {
        $genreFilm = null;

        $films = Film::select('id', 'title', 'poster', 'year')
            ->when($request->q, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->paginate(18)
            ->withQueryString();

        return view('components/movies', compact('films', 'genreFilm'));
    }

    public function moviesByGenre(Genre $genre)
    {
        $genreFilm = $genre;

        $films = Film::select('id', 'title', 'poster', 'year')
            ->where('genre_id', $genre->id)
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->paginate(18);

        return view('components/movies', compact('films', 'genreFilm'));
    }

    public function show(Film $film)
    {
        $film->load('genre');

        $filmByGenre = Film::select('id', 'title', 'poster', 'year', 'sinopsis')
            ->where('genre_id', $film->genre_id)
            ->where('id', '!=', $film->id)
            ->orderBy('created_at', 'asc')
            ->limit(7)
            ->get();

        $filmByRelease = Film::select('id', 'title', 'poster', 'year')
            ->where('id', '!=', $film->id)
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->limit(9)
            ->get();

        // relasi di-load sekaligus (eager loading) supaya tidak N+1 query
        $comments = $film->kritiks()->with('user:id,name')->latest('id')->limit(10)->get();
        $perans   = $film->perans()->with('cast:id,name')->get();

        return view('components.movie-show', compact('film', 'filmByGenre', 'filmByRelease', 'comments', 'perans'));
    }

    /* =====================================================
     |  ADMIN CRUD  (prefix /admin, middleware auth + admin)
     ===================================================== */

    public function index(Request $request)
    {
        $films = Film::with('genre:id,name')
            ->when($request->q, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.form', [
            'film'   => new Film,
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function store(StoreFilmRequest $request)
    {
        $data = $request->validated();
        // simpan file ke storage/app/public/images -> di DB cukup "images/namafile.jpg"
        $data['poster'] = $request->file('poster')->store('images', 'public');

        Film::create($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan.');
    }

    public function edit(Film $film)
    {
        return view('admin.films.form', [
            'film'   => $film,
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateFilmRequest $request, Film $film)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $film->deletePosterFile(); // buang poster lama
            $data['poster'] = $request->file('poster')->store('images', 'public');
        } else {
            unset($data['poster']);    // tidak upload baru -> pakai poster lama
        }

        $film->update($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film)
    {
        DB::transaction(function () use ($film) {
            $film->deletePosterFile();
            $film->perans()->delete();
            $film->kritiks()->delete();
            $film->delete();
        });

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus.');
    }
}
