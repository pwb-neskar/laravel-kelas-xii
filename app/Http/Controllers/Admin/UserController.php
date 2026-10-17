<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role:id,name')
            ->when($request->q, fn ($query, $term) => $query
                ->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user'  => new User,
            'roles' => Role::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        DB::transaction(function () use ($data) {
            $profile = Profile::create($this->profileData($data));

            User::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => $data['password'],
                'role_id'    => $data['role_id'],
                'profile_id' => $profile->id,
            ]);
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $user->load('profile');

        return view('admin.users.form', [
            'user'  => $user,
            'roles' => Role::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate($this->rules($user));

        DB::transaction(function () use ($data, $user) {
            $payload = [
                'name'    => $data['name'],
                'email'   => $data['email'],
                'role_id' => $data['role_id'],
            ];
            if (!empty($data['password'])) {
                $payload['password'] = $data['password'];
            }
            $user->update($payload);

            $profile = $user->profile ?? new Profile;
            $profile->fill($this->profileData($data))->save();
            if ($user->profile_id !== $profile->id) {
                $user->update(['profile_id' => $profile->id]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        DB::transaction(function () use ($user) {
            $profile = $user->profile;
            $user->kritiks()->delete();
            $user->delete();
            $profile?->delete(); // user dihapus dulu karena users.profile_id mereferensi profiles
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    private function rules(?User $user = null): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email' . ($user ? ',' . $user->id : '')],
            // wajib saat membuat user, opsional saat edit (kosong = password tidak diganti)
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'role_id'  => ['required', 'exists:roles,id'],
            'umur'     => ['nullable', 'integer', 'between:0,120'],
            'bio'      => ['nullable', 'string', 'max:1000'],
            'alamat'   => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function profileData(array $data): array
    {
        return [
            'umur'   => $data['umur'] ?? 0,
            'bio'    => $data['bio'] ?? '',
            'alamat' => $data['alamat'] ?? '',
        ];
    }
}
