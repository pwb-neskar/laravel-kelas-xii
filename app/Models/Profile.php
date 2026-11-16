<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['alamat', 'umur', 'bio'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}