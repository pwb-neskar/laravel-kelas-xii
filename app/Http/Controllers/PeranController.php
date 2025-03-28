<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use App\Models\Cast;
use App\Models\Film;
use App\Http\Requests\StorePeranRequest;
use App\Http\Requests\UpdatePeranRequest;
use App\Http\Controllers\PeranController;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perans = Peran::paginate(50);
        return view('peran.index', compact('perans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Peran.create-peran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeranRequest $request)
    {
        $request->validate([
            'actor' => 'required|string|max:255',
            'cast_id' => 'required|integer',
            'film_id' => 'required|integer',
        ]);
    
        Peran::create($request->all());
        return redirect()->route('Peran.index')->with('success', 'Peran berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $perans = Peran::findOrFail($id);
        return view('Peran.show-peran', compact('perans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       
        $peran = Peran::findOrFail($id);

        $casts = Cast::all(); 
        $films = Film::all(); 

        // Mengembalikan view dengan data yang diperlukan
        return view('Peran.edit-peran', compact('peran', 'casts', 'films'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
        {
            // Validasi data
            $peran = Peran::find($id);
        if (!$peran) {
            return response()->json(['error' => 'Peran tidak ditemukan.'], 404);
            }

        $peran->aktor = $request->aktor;
        $peran->cast_id = $request->cast_id;
        $peran->film_id = $request->film_id;
        $peran->save();

        return response()->json(['success' => 'Peran berhasil diperbarui.']);
        }
     
        public function destroy($id)
        {
            // Temukan data berdasarkan ID
            $peran = Peran::find($id);
        
            // Cek apakah data ditemukan
            if (!$peran) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
        
            // Hapus data
            $peran->delete();
        
            return response()->json(['success' => 'Data berhasil dihapus']);
        }
}
