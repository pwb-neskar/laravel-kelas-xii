<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $genres = Genre::withCount('films')
            ->when($request->q, fn ($query, $term) => $query->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.form', ['genre' => new Genre]);
    }

    public function store(Request $request)
    {
        Genre::create($request->validate([
            'name' => ['required', 'string', 'max:45', 'unique:genres,name'],
        ]));

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.form', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $genre->update($request->validate([
            'name' => ['required', 'string', 'max:45', 'unique:genres,name,' . $genre->id],
        ]));

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre)
    {
        if ($genre->films()->exists()) {
            return back()->with('error', 'Genre masih dipakai oleh film, hapus / pindahkan film-nya dulu.');
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus.');
    }
}
