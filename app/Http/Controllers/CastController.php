<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCastRequest;
use App\Http\Requests\UpdateCastRequest;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CastController extends Controller
{
    public function index(Request $request)
    {
        $casts = Cast::withCount('perans')
            ->when($request->q, fn ($query, $term) => $query->where('name', 'like', "%{$term}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.casts.index', compact('casts'));
    }

    public function create()
    {
        return view('admin.casts.form', ['cast' => new Cast]);
    }

    public function store(StoreCastRequest $request)
    {
        Cast::create($request->validated());

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil ditambahkan.');
    }

    public function edit(Cast $cast)
    {
        return view('admin.casts.form', compact('cast'));
    }

    public function update(UpdateCastRequest $request, Cast $cast)
    {
        $cast->update($request->validated());

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil diperbarui.');
    }

    public function destroy(Cast $cast)
    {
        DB::transaction(function () use ($cast) {
            $cast->perans()->delete();
            $cast->delete();
        });

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil dihapus.');
    }
}
