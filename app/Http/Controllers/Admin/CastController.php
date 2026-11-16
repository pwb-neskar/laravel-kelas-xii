<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Peran;
use Illuminate\Http\Request;

class CastController extends Controller
{
    public function index()
    {
        $casts = Cast::orderBy('name')->paginate(10);

        return view('admin.casts.index', compact('casts'));
    }

    public function create()
    {
        return view('admin.casts.form', ['cast' => new Cast()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Cast::forceCreate($data);

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil ditambahkan.');
    }

    public function edit(Cast $cast)
    {
        return view('admin.casts.form', compact('cast'));
    }

    public function update(Request $request, Cast $cast)
    {
        $data = $request->validate($this->rules());

        $cast->forceFill($data)->save();

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil diperbarui.');
    }

    public function destroy(Cast $cast)
    {
        if (Peran::where('cast_id', $cast->id)->exists()) {
            return back()->with('error', 'Cast masih punya peran di film, hapus perannya dulu.');
        }

        $cast->delete();

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:45'],
            'age'  => ['required', 'integer', 'min:1', 'max:150'],
            'bio'  => ['required', 'string'],
        ];
    }
}