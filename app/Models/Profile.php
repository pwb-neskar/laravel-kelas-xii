<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $fillable = ['umur', 'bio', 'alamat'];

    // Satu profile dimiliki satu user
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
