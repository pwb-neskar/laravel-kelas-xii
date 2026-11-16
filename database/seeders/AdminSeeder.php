<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    // Sesuaikan dengan kolom "name" di tabel roles untuk admin
    private const ROLE_ADMIN = 'admin';

    public function run(): void
    {
        $role = Role::where('name', self::ROLE_ADMIN)->firstOrFail();

        // Kalau akun admin sudah ada, cukup pastikan rolenya benar
        $existing = User::where('email', 'admin@example.com')->first();
        if ($existing) {
            $existing->update(['role_id' => $role->id]);
            return;
        }

        $faker = Faker::create('id_ID');

        $profile = Profile::create([
            'alamat' => $faker->address,
            'umur'   => $faker->numberBetween(1, 50),
            'bio'    => 'administrator',
        ]);

        User::create([
            'name'              => 'admin',
            'email'             => 'admin@example.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'),
            'remember_token'    => Str::random(10),
            'role_id'           => $role->id,
            'profile_id'        => $profile->id,
        ]);
    }
}