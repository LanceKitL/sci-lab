<x-app-layout>
    @section('header', 'Approval History')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Navigation Tabs --}}
        <div class="flex gap-4 mb-6">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-white font-bold transition">Pending Requests</a>
            <a href="{{ route('admin.users.history') }}" class="px-4 py-2 border-b-2 border-scilab-blue text-white font-bold">Approval History</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 uppercase font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Approved Date</th>
                            <th class="px-6 py-4">Approved By</th>
                            <th class="px-6 py-4 text-center">ID Card</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($approvedUsers as $user)
                        <tr class="hover:bg-gray-50 transition">
                            
                            {{-- User Info --}}
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold uppercase">
                                    {{ $user->role }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold">{{ $user->approved_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-gray-400">{{ $user->approved_at->format('h:i A') }}</span>
                                </div>
                            </td>

                            {{-- Approved By (Admin Name) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold">
                                        {{ substr($user->approver->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium">{{ $user->approver->name ?? 'Unknown Admin' }}</span>
                                </div>
                            </td>

                            {{-- View ID --}}
                            <td class="px-6 py-4 text-center">
                                @if($user->id_image_path)
                                    <a href="{{ asset('storage/'.$user->id_image_path) }}" target="_blank" class="text-scilab-blue hover:underline text-xs font-bold">View ID</a>
                                @else
                                    <span class="text-gray-400 text-xs">No ID</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if($approvedUsers->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                No records found.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>