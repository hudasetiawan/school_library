<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id'             => 'required|exists:books,id',
            'tanggal_jatuh_tempo' => 'required|date|after:today',
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
            'book_id'             => 'Buku',
            'tanggal_jatuh_tempo' => 'Tanggal Kembali',
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
            'book_id.required'             => 'Buku wajib dipilih.',
            'book_id.exists'               => 'Buku yang dipilih tidak valid.',
            'tanggal_jatuh_tempo.required'  => 'Tanggal kembali wajib diisi.',
            'tanggal_jatuh_tempo.after'     => 'Tanggal kembali harus setelah hari ini.',
        ];
    }
}
