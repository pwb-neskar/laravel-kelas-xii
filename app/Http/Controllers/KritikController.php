<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use Illuminate\Http\Request;

class KritikController extends Controller
{
    public function store(Request $request, Film $film)
    {
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'rating'  => ['required', 'integer', 'between:1,5'],
        ]);

        // Diisi satu per satu supaya tidak bergantung pada $fillable di model Kritik
        $kritik = new Kritik();
        $kritik->comment = $data['comment'];
        $kritik->rating  = $data['rating'];
        $kritik->user_id = $request->user()->id; // dari sesi login, bukan dari form
        $kritik->film_id = $film->id;
        $kritik->save();

        return redirect()
            ->route('movies.show', $film)
            ->with('success', 'Kritik berhasil dikirim.');
    }
}