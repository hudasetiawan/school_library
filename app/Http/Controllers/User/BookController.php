<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(protected BookService $bookService)
    {
    }

    public function index(Request $request)
    {
        $search     = $request->input('search');
        $categoryId = $request->input('category_id');
        $perPage    = (int) $request->input('per_page', 10);

        $books = $this->bookService->getAllBooks($search, $categoryId ? (int) $categoryId : null, $perPage);
        $categories = Category::orderBy('nama_kategori')->get();

        return view('user.books.index', compact('books', 'search', 'categoryId', 'categories', 'perPage'));
    }

    public function show(\App\Models\Book $book)
    {
        $book->load('category'); // Eager load
        return view('user.books.show', compact('book'));
    }
}
