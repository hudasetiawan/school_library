<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BorrowingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function __construct(protected BorrowingService $borrowingService)
    {
    }

    /**
     * Display borrowing history for the authenticated user.
     * Supports search by book title and filter by status.
     */
    public function index(Request $request): View
    {
        $search  = $request->input('search');
        $status  = $request->input('status');
        $perPage = (int) $request->input('per_page', 10);

        $borrowings = $this->borrowingService->getUserBorrowings(
            auth()->id(),
            $search,
            $status,
            $perPage
        );

        return view('user.borrowings.index', compact('borrowings', 'search', 'status', 'perPage'));
    }
}
