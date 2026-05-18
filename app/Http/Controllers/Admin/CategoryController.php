<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request): View
    {
        $search  = $request->input('search');
        $status  = $request->input('status');
        $perPage = (int) $request->input('per_page', 10);

        $categories = Category::withCount('books')
            ->when($search, fn ($query, $search) => $query->where('nama_kategori', 'like', "%{$search}%"))
            ->when($status === 'terisi', fn ($query) => $query->has('books'))
            ->when($status === 'kosong', fn ($query) => $query->doesntHave('books'))
            ->orderBy('nama_kategori')
            ->paginate($perPage);

        return view('admin.categories.index', compact('categories', 'search', 'status', 'perPage'));
    }

    /**
     * Store a newly created category (AJAX endpoint).
     * Returns JSON for inline modal usage in book form.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori ini sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category = Category::create($validated);

        // Return JSON for AJAX requests (e.g. from category-select modal)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'category' => [
                    'id'   => $category->id,
                    'nama' => $category->nama_kategori,
                ],
            ], 201);
        }

        // Return redirect for regular form submissions (categories index page)
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('categories')->ignore($category->id)],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori ini sudah ada.',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     * Restrict deletion if category still has books.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->books()->exists()) {
            return redirect()->back()->with('error',
                "Kategori \"{$category->nama_kategori}\" tidak dapat dihapus karena masih memiliki {$category->books()->count()} buku terkait."
            );
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
