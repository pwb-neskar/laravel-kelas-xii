<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::select('films.id', 'films.title', 'films.year', 'films.poster', 'genres.name as genre_name')
            ->leftJoin('genres', 'genres.id', '=', 'films.genre_id')
            ->orderByDesc('films.year')
            ->orderBy('films.title')
            ->paginate(10);

        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.form', [
            'film'   => new Film(),
            'genres' => Genre::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['poster'] = $this->savePoster($request);

        // forceCreate: hanya data yang lolos validasi yang disimpan
        Film::forceCreate($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan.');
    }

    public function edit(Film $film)
    {
        return view('admin.films.form', [
            'film'   => $film,
            'genres' => Genre::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Film $film)
    {
        $data = $this->validated($request, false);

        // Poster hanya diganti kalau admin mengunggah file baru
        if ($request->hasFile('poster')) {
            $data['poster'] = $this->savePoster($request);
        }

        $film->forceFill($data)->save();

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film)
    {
        // Hapus data yang bergantung pada film ini dulu (foreign key)
        DB::transaction(function () use ($film) {
            Peran::where('film_id', $film->id)->delete();
            Kritik::where('film_id', $film->id)->delete();
            $film->delete();
        });

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus.');
    }

    private function validated(Request $request, bool $posterWajib): array
    {
        $data = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'year'     => ['required', 'integer', 'min:1888', 'max:2100'],
            'sinopsis' => ['required', 'string'],
            'genre_id' => ['required', 'exists:genres,id'],
            'poster'   => [$posterWajib ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Kolom poster diisi terpisah (path file), bukan objek upload
        return Arr::except($data, ['poster']);
    }

    private function savePoster(Request $request): string
    {
        // Disimpan di storage/app/public/images, diakses lewat /storage/images/...
        return 'storage/'.$request->file('poster')->store('images', 'public');
    }
}