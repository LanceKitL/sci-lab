<div class="flex items-center gap-2">
    @if($record->status === 'pending')
        @if(Auth::user()->role === 'admin')
            {{-- Approve --}}
            <form action="{{ route('borrow.approve', $record->id) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 font-bold text-xs transition" title="Approve">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Approve
                </button>
            </form>

            {{-- Reject --}}
            <form action="{{ route('borrow.reject', $record->id) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-bold text-xs transition" title="Reject">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Reject
                </button>
            </form>
        @else
            <span class="text-xs text-gray-500 italic px-3 py-1.5 bg-gray-50 rounded-lg">Awaiting</span>
        @endif

    @elseif($record->status === 'active')
        @if(Auth::user()->role === 'admin')
            <form action="{{ route('borrow.return', $record->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded-lg shadow-sm hover:shadow text-xs transition">
                    Mark Returned
                </button>
            </form>
        @else
            <span class="text-xs text-blue-700 font-bold px-3 py-1.5 bg-blue-50 rounded-lg">In Use</span>
        @endif

    @else
        <span class="text-xs text-gray-400 font-medium px-3 py-1.5 bg-gray-50 rounded-lg">Completed</span>
    @endif
</div>