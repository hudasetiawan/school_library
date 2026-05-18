<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookService
{
    /**
     * Get all books with eager-loaded category.
     * Supports search by judul/penulis/kode_buku and filter by category_id.
     * Uses Eloquent when() for efficient conditional querying at DB level.
     */
    public function getAllBooks(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Book::query()
            ->with('category') // Eager Loading — mencegah N+1
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%")
                      ->orWhere('kode_buku', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%")
                      ->orWhere('kode_rak', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create a new book record.
     * Stok tersedia otomatis disamakan dengan total eksemplar.
     * Cover image otomatis dikonversi ke format WebP (kualitas 80).
     */
    public function createBook(array $data): Book
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $data['cover_image'] = $this->convertAndStoreAsWebp($data['cover_image']);
        }

        // Set stok_tersedia sama dengan total_eksemplar saat pertama kali dibuat
        $data['stok_tersedia'] = $data['total_eksemplar'];

        return Book::create($data);
    }

    /**
     * Update an existing book record.
     * Handles cover_image replacement and old file cleanup.
     * Cover image otomatis dikonversi ke format WebP (kualitas 80).
     */
    public function updateBook(Book $book, array $data): Book
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            // Hapus file gambar lama jika ada
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $this->convertAndStoreAsWebp($data['cover_image']);
        }

        $book->update($data);
        return $book;
    }

    /**
     * Delete a book and its cover image from storage.
     */
    public function deleteBook(Book $book): bool
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        return $book->delete();
    }

    /**
     * Konversi file gambar yang diunggah (PNG/JPG/JPEG) menjadi format WebP
     * lalu simpan ke storage/app/public/books/.
     *
     * @param  UploadedFile  $file  File gambar yang diunggah
     * @return string  Path relatif file WebP yang tersimpan (e.g. "books/cover_abc123.webp")
     */
    private function convertAndStoreAsWebp(UploadedFile $file): string
    {
        // Buat nama file unik dengan ekstensi .webp
        $filename = 'cover_' . Str::random(10) . '.webp';
        $relativePath = 'books/' . $filename;

        // Baca file yang diunggah menggunakan Intervention Image (GD driver)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname());

        // Encode ke WebP dengan kualitas 80
        $encoded = $image->toWebp(80);

        // Simpan ke storage disk 'public'
        Storage::disk('public')->put($relativePath, (string) $encoded);

        return $relativePath;
    }
}
