<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Menfess;
use Illuminate\Http\Request;

class MenfessController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $menfesses = Menfess::with('book')
            ->where('status', 'approved')
            ->latest()
            ->paginate($perPage);
            
        $books = Book::all(); // optimize later if too many books

        return view('user.menfess.index', compact('menfesses', 'books', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'book_id' => 'nullable|exists:books,id',
            'sender' => 'nullable|string|max:50',
            'receiver' => 'required|string|max:50',
        ]);

        Menfess::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'],
            'message' => $validated['message'],
            'status' => 'pending',
            'sender' => $validated['sender'] ?: 'Anonymous',
            'receiver' => $validated['receiver'],
        ]);

        return redirect()->back()->with('success', 'Menfess berhasil dikirim dan menunggu moderasi admin.');
    }
    
    public function report(Request $request, Menfess $menfess)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $menfess->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $validated['reason'],
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim.');
    }
}
