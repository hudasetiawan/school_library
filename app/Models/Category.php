<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    /**
     * Boot the model.
     * Auto-generate slug from nama_kategori when creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nama_kategori);
            }
        });

        static::updating(function (Category $category) {
            if ($category->isDirty('nama_kategori')) {
                $category->slug = Str::slug($category->nama_kategori);
            }
        });
    }

    /**
     * Get all books belonging to this category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
