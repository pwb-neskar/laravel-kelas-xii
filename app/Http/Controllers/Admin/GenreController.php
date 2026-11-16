<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('name')->paginate(10);

        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.form', ['genre' => new Genre()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // forceCreate: hanya data yang lolos validasi yang disimpan
        Genre::forceCreate($data);

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.form', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $data = $request->validate($this->rules());

        $genre->forceFill($data)->save();

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre)
    {
        if (Film::where('genre_id', $genre->id)->exists()) {
            return back()->with('error', 'Genre masih dipakai oleh film, tidak bisa dihapus.');
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:45'],
        ];
    }
}