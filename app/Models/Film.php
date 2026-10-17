<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';
    protected $fillable = ['title', 'sinopsis', 'year', 'poster', 'genre_id'];

    /* ---------- Relasi ---------- */

    // Film milik satu Genre
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    // Film punya banyak Peran (tabel perans = tabel penghubung film <-> cast)
    public function perans(): HasMany
    {
        return $this->hasMany(Peran::class);
    }

    // Film punya banyak Kritik (komentar + rating)
    public function kritiks(): HasMany
    {
        return $this->hasMany(Kritik::class);
    }

    // Shortcut many-to-many: film -> cast (lewat tabel perans)
    // (tidak boleh dinamai casts() karena bentrok dengan method casts() bawaan Eloquent)
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Cast::class, 'perans')->withPivot('actor')->withTimestamps();
    }

    /* ---------- Poster / storage ---------- */

    // $film->poster_url  -> URL gambar yang siap dipakai di <img>
    protected function posterUrl(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->poster) {
                return asset('template/images/1.jpg');
            }
            if (str_starts_with($this->poster, 'http')) {
                return $this->poster;
            }
            // data lama masih ada yang berawalan "storage/", data baru "images/xxx.jpg"
            return asset(str_starts_with($this->poster, 'storage/') ? $this->poster : 'storage/' . $this->poster);
        });
    }

    // Path poster relatif terhadap disk "public" (storage/app/public)
    public function posterPath(): string
    {
        return preg_replace('#^storage/#', '', (string) $this->poster);
    }

    // Hapus file poster dari storage, tapi hanya jika tidak dipakai film lain
    public function deletePosterFile(): void
    {
        $path = $this->posterPath();
        if ($path === '') {
            return;
        }

        $dipakaiFilmLain = static::where('id', '!=', $this->id)
            ->whereIn('poster', [$path, 'storage/' . $path])
            ->exists();

        if (!$dipakaiFilmLain) {
            Storage::disk('public')->delete($path);
        }
    }
}
