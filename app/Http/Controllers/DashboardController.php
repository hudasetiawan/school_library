<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $totalBooks = Book::count();
            $totalUsers = User::where('role', 'user')->count();
            $activeBorrowings = Borrowing::where('status', 'disetujui')->count();
            $pendingBorrowings = Borrowing::where('status', 'pending')->count();

            return view('dashboard', compact('totalBooks', 'totalUsers', 'activeBorrowings', 'pendingBorrowings'));
        }

        // For regular user
        $myActiveBorrowings = Borrowing::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();

        return view('dashboard', compact('myActiveBorrowings'));
    }
}
