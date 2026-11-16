<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Lihat profil sendiri
    public function show(Request $request)
    {
        $user = $request->user()->load('profile');

        return view('components.profile', compact('user'));
    }

    // Form ubah profil sendiri
    public function edit(Request $request)
    {
        $user = $request->user()->load('profile');

        return view('components.profile-edit', compact('user'));
    }

    // Simpan perubahan profil sendiri
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'alamat' => ['nullable', 'string', 'max:255'],
            'umur'   => ['nullable', 'integer', 'min:1', 'max:120'],
            'bio'    => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // Kolom profil bisa NOT NULL di database, jadi kosong diganti nilai bawaan
        $user->profile->update([
            'alamat' => $data['alamat'] ?? '-',
            'umur'   => $data['umur'] ?? 0,
            'bio'    => $data['bio'] ?? '-',
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}