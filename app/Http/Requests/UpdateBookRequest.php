<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_buku' => 'required|string|max:50|unique:books,kode_buku,' . $this->book->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'kode_rak' => 'required|string|max:50',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $this->book->id,
            'total_eksemplar' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'kode_buku' => 'Kode Buku',
            'judul' => 'Judul',
            'penulis' => 'Penulis',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
            'category_id' => 'Kategori',
            'kode_rak' => 'Kode Rak',
            'isbn' => 'ISBN',
            'total_eksemplar' => 'Total Eksemplar',
            'stok_tersedia' => 'Stok Tersedia',
            'cover_image' => 'Cover Buku',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_buku.unique' => 'Kode Buku sudah digunakan, silakan gunakan kode lain.',
            'isbn.unique' => 'ISBN sudah terdaftar di sistem, silakan periksa kembali.',
            'isbn.max' => 'ISBN maksimal 20 karakter.',
            'cover_image.mimes' => 'Cover Buku harus berformat JPG, PNG, atau WebP.',
            'cover_image.max' => 'Ukuran Cover Buku maksimal 2MB.',
            'total_eksemplar.min' => 'Total Eksemplar tidak boleh kurang dari 0.',
            'stok_tersedia.min' => 'Stok Tersedia tidak boleh kurang dari 0.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}
