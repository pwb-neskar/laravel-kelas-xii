<?php

    namespace App\Http\Controllers;

    use App\Models\{
        Film,
        Genre,
        Peran,
    };
    use App\Http\Requests\StoreFilmRequest;
    use App\Http\Requests\UpdateFilmRequest;
    use Carbon\Carbon;


    class FilmController extends Controller
    {
        /**
         * Display a listing of the resource.
         */

        public function index()
        {
            $films = Film::all();
            $genres = Genre::all();
            return view('film.index', compact('films','genres'));
        }

        public function movies()
        {
            //
            $genreFilm = null;
            $films = Film::select('id','title', 'poster','year')
                    ->orderByDesc('year')
                    ->OrderBy('created_at', 'asc')
                    ->paginate(18);
            return view('components/movies', compact('films', 'genreFilm'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            $genres = Genre::all();
            return view('film.create', compact('genres'));
        }

        /**
         * Store a newly created resource in storage.
         */
    public function store(StoreFilmRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('public/images');
            $validated['poster'] = str_replace('public/', '/storage', 'app/', $posterPath);
        }

        Film::create($validated);

        return redirect()->route('film.index')->with('success', 'Berhasil menambahkan data FILM');
    }


        /**
         * Display the specified resource.
         */
        public function show(Film $film)
        {
            //
            $filmByGenre    = Film::select('id','title', 'poster','year', 'sinopsis')
                            ->where('genre_id', '=', $film->genre_id)
                            ->OrderBy('created_at', 'asc')
                            ->limit(7)
                            ->get();
            $filmByRelease  = Film::select('id','title', 'poster','year')
                            ->where('year', '=', Carbon::now()->format('Y'))
                            ->OrderBy('created_at', 'asc')
                            ->limit(9)
                            ->get();
            
            $perans         = Peran::all()->where('film_id', '=', $film->id);
            return view('components.movie-show', compact('film','filmByGenre','filmByRelease', 'perans'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Film $film)
        {
            $genres = Genre::all();
            return view('film.edit', compact('film','genres'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(UpdateFilmRequest $request, Film $film)
    {
        $validated = $request->validated();

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('public/images');
            $validated['poster'] = str_replace('public/', '', $posterPath);
        }

        $film->update($validated);
        return response()->json(['success' => 'Berhasil memperbarui data FILM']);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Film $film)
        {
            // Hapus kritik yang terkait
            Kritik::where('film_id', $film->id)->delete();
            peran::where('film_id', $film->id)->delete();

            // Hapus film
            $film->delete();

            return redirect()->route('film.index')->with('succes', 'Berhasil menghapus data FILM');
        }

        public function movieHome()
        {
            $films = Film::select('id','title', 'poster','year')
                    ->OrderBy('created_at', 'asc')
                    ->limit(9)->get();
            $filmFutured = Film::select('id','title', 'poster','year')
                            ->orderByDesc('year')
                            ->OrderBy('created_at', 'asc')
                            ->limit(6)->get();
            $filmRecentAdded = Film::select('id','title', 'poster','year')
                                ->orderByDesc('created_at', 'asc')
                                ->limit(6)->get();
            $filmSlidey = Film::select('title', 'poster','sinopsis')
                            ->orderByDesc('year')
                            ->OrderBy('created_at', 'asc')
                            ->limit(6)->get();
            return view('components/home', compact('filmSlidey','films','filmFutured','filmRecentAdded'));
        }

        public function moviesByGenre($genre)
        {
            //
            $genreFilm = Genre::where('id', '=', $genre)->first();
            $films = Film::select('id','title', 'poster','year')
                    ->where('genre_id', '=', $genre)
                    ->orderByDesc('year')
                    ->OrderBy('created_at', 'asc')
                    ->paginate(18);
            return view('components/movies', compact('films','genreFilm'));
        }
    }
