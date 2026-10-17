<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

/**
 * Profil milik user yang sedang login (bukan CRUD semua profil;
 * pengelolaan semua user ada di Admin\UserController).
 */
class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load('profile', 'role');

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');

        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($user, $data) {
            $user->update(['name' => $data['name']]);

            $profile = $user->profile ?? new Profile;
            $profile->fill([
                'umur'   => $data['umur'],
                'bio'    => $data['bio'] ?? '',
                'alamat' => $data['alamat'] ?? '',
            ])->save();

            if ($user->profile_id !== $profile->id) {
                $user->update(['profile_id' => $profile->id]);
            }
        });

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
