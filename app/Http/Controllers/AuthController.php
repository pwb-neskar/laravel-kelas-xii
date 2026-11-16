<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Sesuaikan dengan kolom "name" di tabel roles untuk user biasa
    private const ROLE_USER = 'user';

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'))
            ->with('openLogin', true);
    }

    public function register(Request $request)
    {
        // Error register disimpan di bag terpisah ("register")
        // supaya tidak tercampur dengan error login.
        $data = $request->validateWithBag('register', [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Role ditentukan server, BUKAN dari input form,
        // supaya tidak ada yang bisa mendaftar sebagai admin.
        $role = Role::where('name', self::ROLE_USER)->firstOrFail();

        $user = DB::transaction(function () use ($data, $role) {
            // users.profile_id wajib, jadi profile dibuat dulu.
            // Isinya placeholder, nanti diubah user di halaman profil.
            $profile = Profile::create([
                'alamat' => '-',
                'umur'   => 0,
                'bio'    => '-',
            ]);

            return User::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => $data['password'], // di-hash otomatis oleh cast "hashed"
                'role_id'    => $role->id,
                'profile_id' => $profile->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}