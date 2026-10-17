<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKritikRequest;
use App\Http\Requests\UpdateKritikRequest;
use App\Models\Film;
use App\Models\Kritik;
use App\Models\User;
use Illuminate\Http\Request;

class KritikController extends Controller
{
    /* ---------- Publik: user yang login mengirim komentar ---------- */

    public function comment(Request $request, Film $film)
    {
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'rating'  => ['required', 'integer', 'between:1,5'],
        ]);

        $film->kritiks()->create($data + ['user_id' => $request->user()->id]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    /* ---------- Admin CRUD ---------- */

    public function index(Request $request)
    {
        $kritiks = Kritik::with(['film:id,title', 'user:id,name'])
            ->when($request->q, fn ($query, $term) => $query->where('comment', 'like', "%{$term}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kritiks.index', compact('kritiks'));
    }

    public function create()
    {
        return view('admin.kritiks.form', [
            'kritik' => new Kritik,
            'films'  => Film::orderBy('title')->get(['id', 'title']),
            'users'  => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreKritikRequest $request)
    {
        Kritik::create($request->validated());

        return redirect()->route('admin.kritiks.index')->with('success', 'Kritik berhasil ditambahkan.');
    }

    public function edit(Kritik $kritik)
    {
        return view('admin.kritiks.form', [
            'kritik' => $kritik,
            'films'  => Film::orderBy('title')->get(['id', 'title']),
            'users'  => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateKritikRequest $request, Kritik $kritik)
    {
        $kritik->update($request->validated());

        return redirect()->route('admin.kritiks.index')->with('success', 'Kritik berhasil diperbarui.');
    }

    public function destroy(Kritik $kritik)
    {
        $kritik->delete();

        return redirect()->route('admin.kritiks.index')->with('success', 'Kritik berhasil dihapus.');
    }
}
