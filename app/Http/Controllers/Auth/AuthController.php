<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Form login ada di modal (templates/component/login.blade.php),
     * jadi /login cukup mengarahkan ke home dan membuka modalnya.
     * Route ini juga dipakai middleware "auth" sebagai tujuan redirect.
     */
    public function showLogin(): RedirectResponse
    {
        return redirect()->route('home')->with('open_login', true);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validateWithBag('login', [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'], 'login')
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // Admin -> dashboard, user biasa -> halaman sebelumnya / home
        $default = Auth::user()->isAdmin() ? route('admin.dashboard') : route('home');

        return redirect()->intended($default);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('register', [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($data) {
            // kolom profile_id & role_id di tabel users wajib diisi
            $profile = Profile::create(['umur' => 0, 'bio' => '', 'alamat' => '']);

            return User::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => $data['password'], // di-hash otomatis oleh cast 'hashed'
                'role_id'    => Role::where('name', 'user')->value('id') ?? 1,
                'profile_id' => $profile->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registrasi berhasil, selamat datang!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
