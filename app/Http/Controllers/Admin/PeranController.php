<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    public function index()
    {
        $perans = Peran::select('perans.id', 'perans.actor', 'films.title as film_title', 'casts.name as cast_name')
            ->join('films', 'films.id', '=', 'perans.film_id')
            ->join('casts', 'casts.id', '=', 'perans.cast_id')
            ->orderBy('films.title')
            ->orderBy('perans.id')
            ->paginate(10);

        return view('admin.perans.index', compact('perans'));
    }

    public function create()
    {
        return view('admin.perans.form', $this->formData(new Peran()));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Peran::forceCreate($data);

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil ditambahkan.');
    }

    public function edit(Peran $peran)
    {
        return view('admin.perans.form', $this->formData($peran));
    }

    public function update(Request $request, Peran $peran)
    {
        $data = $request->validate($this->rules());

        $peran->forceFill($data)->save();

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil diperbarui.');
    }

    public function destroy(Peran $peran)
    {
        $peran->delete();

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil dihapus.');
    }

    private function formData(Peran $peran): array
    {
        return [
            'peran' => $peran,
            'films' => Film::orderBy('title')->get(['id', 'title']),
            'casts' => Cast::orderBy('name')->get(['id', 'name']),
        ];
    }

    private function rules(): array
    {
        return [
            'film_id' => ['required', 'exists:films,id'],
            'cast_id' => ['required', 'exists:casts,id'],
            'actor'   => ['required', 'string', 'max:255'],
        ];
    }
}