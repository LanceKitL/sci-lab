<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BorrowController extends Controller
{
    /**
     * Display the list of borrowing records.
     */
    public function index(Request $request)
    {
        // 1. Start the query with relationships to optimize performance
        $query = Borrowing::with(['user', 'equipment', 'attendance']);

        // 2. Role-based Visibility
        if (Auth::user()->role !== 'admin') {
            // Students/Teachers only see their own records
            $query->where('user_id', Auth::id());
        } else {
            // ADMIN ONLY: Search Logic
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('transaction_id', 'LIKE', "%{$search}%")
                      ->orWhereHas('equipment', function($sq) use ($search) {
                          $sq->where('name', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('user', function($sq) use ($search) {
                          $sq->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }

            // ADMIN ONLY: Filter by Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        }

        // 3. Order by Latest & Paginate
        $borrowings = $query->latest('borrowed_at')
                            ->paginate(12)
                            ->withQueryString();

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Store a new borrowing request (sets status to 'pending').
     */
    public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        // 2. Check Availability
        if ($equipment->available < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        // 3. Create Record (Status = PENDING)
        // We deduct stock immediately to "Reserve" the item.
        // If rejected later, we will add the stock back.
        Borrowing::create([
            'transaction_id' => strtoupper(Str::random(10)),
            'user_id' => Auth::id(),
            'equipment_id' => $equipment->id,
            'quantity' => $request->quantity,
            'status' => 'pending', // <--- Default is Pending
            'borrowed_at' => now(),
        ]);

        // 4. Deduct Stock (Reservation)
        $equipment->decrement('available', $request->quantity);

        return redirect()->back()->with('success', 'Request submitted! Waiting for Admin approval.');
    }

    /**
     * Approve a pending request (Admin only).
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
            }

            // Change status to active (Officially Borrowed)
            $borrowing->update(['status' => 'active']);

            return redirect()->back()->with('success', 'Request Approved. Student can now take the item.');
        }

        /**
         * Reject a pending request (Admin only).
         */
        public function reject($id)
        {
            $borrowing = Borrowing::findOrFail($id);

            if ($borrowing->status !== 'pending') {
                return redirect()->back()->with('error', 'You can only reject pending requests.');
            }

            // 1. Restore the Stock (Since we deducted it during reservation)
            $borrowing->equipment->increment('available', $borrowing->quantity);

            // 2. Delete the record (Or you could update status to 'rejected' if you want history)
            $borrowing->delete();

            return redirect()->back()->with('success', 'Request Rejected. Stock has been restored.');
        }

        /**
         * Mark an active item as Returned (Admin only).
         */
        public function markAsReturned($id)
        {
            $borrowing = Borrowing::findOrFail($id);

            if ($borrowing->status !== 'active') {
                return redirect()->back()->with('error', 'Item is not currently active.');
            }

            // 1. Update Status
            $borrowing->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            // 2. Return Stock to Inventory
            $borrowing->equipment->increment('available', $borrowing->quantity);

            return redirect()->back()->with('success', 'Item marked as returned.');
        }
}