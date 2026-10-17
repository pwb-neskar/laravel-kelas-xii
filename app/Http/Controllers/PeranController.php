<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeranRequest;
use App\Http\Requests\UpdatePeranRequest;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    public function index(Request $request)
    {
        $perans = Peran::with(['film:id,title', 'cast:id,name'])
            ->when($request->q, fn ($query, $term) => $query->where('actor', 'like', "%{$term}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.perans.index', compact('perans'));
    }

    public function create()
    {
        return view('admin.perans.form', [
            'peran' => new Peran,
            'films' => Film::orderBy('title')->get(['id', 'title']),
            'casts' => Cast::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StorePeranRequest $request)
    {
        Peran::create($request->validated());

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    public function edit(Peran $peran)
    {
        return view('admin.perans.form', [
            'peran' => $peran,
            'films' => Film::orderBy('title')->get(['id', 'title']),
            'casts' => Cast::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdatePeranRequest $request, Peran $peran)
    {
        $peran->update($request->validated());

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil diperbarui.');
    }

    public function destroy(Peran $peran)
    {
        $peran->delete();

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil dihapus.');
    }
}
