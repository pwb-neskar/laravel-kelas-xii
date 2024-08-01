<?php


namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
        protected $fillable = [
            'name',
            'email',
            'password',
            'profile_id',
            'role_id',
        ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'name';
    }
}
