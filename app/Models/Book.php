<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'slug',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'category_id',
        'kode_rak',
        'isbn',
        'total_eksemplar',
        'stok_tersedia',
        'cover_image',
    ];

    /**
     * Boot the model.
     * Auto-generate slug from judul when creating or updating.
     */
    protected static function booted(): void
    {
        static::creating(function (Book $book) {
            $book->slug = static::generateUniqueSlug($book->judul);
        });

        static::updating(function (Book $book) {
            if ($book->isDirty('judul')) {
                $book->slug = static::generateUniqueSlug($book->judul, $book->id);
            }
        });
    }

    /**
     * Generate a unique slug, appending a suffix if collision detected.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Get the category that this book belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all borrowings for this book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
