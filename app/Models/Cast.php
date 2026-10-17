<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cast extends Model
{
    use HasFactory;

    protected $table = 'casts';
    protected $fillable = ['name', 'age', 'bio'];

    // Cast bermain di banyak Peran
    public function perans(): HasMany
    {
        return $this->hasMany(Peran::class);
    }

    // Shortcut many-to-many: cast -> film (lewat tabel perans)
    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'perans')->withPivot('actor')->withTimestamps();
    }
}
