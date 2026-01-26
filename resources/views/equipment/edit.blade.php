<x-app-layout>
    @section('header', 'Edit Equipment')

    <div class="max-w-4xl mx-auto py-12 px-4">
        <!-- Header Card -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Edit Equipment</h1>
                    <p class="text-white">{{ $equipment->name }}</p>
                </div>
                <a href="{{ route('equipment.show', $equipment->id) }}" 
                   class="flex items-center gap-2 px-4 py-2 bg-red-500 py-1 px-3 rounded-md text-white hover:text-gray-900 hover:bg-red-600 rounded-lg  transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Cancel</span>
                </a>
            </div>
        </div>

        <form action="{{ route('equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Basic Information Section -->
                <div class="p-8 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                        Basic Information
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Equipment Name -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Equipment Name *</label>
                            <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition outline-none">
                        </div>

                        <!-- Laboratory -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Laboratory *</label>
                            <div class="relative">
                                <select name="laboratory_id" 
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition outline-none appearance-none bg-white">
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}" {{ $equipment->laboratory_id == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" 
                                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition outline-none resize-none">{{ old('description', $equipment->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Inventory Section -->
                <div class="p-8 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="w-1 h-5 bg-green-600 rounded-full"></div>
                        Inventory Details
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Total Quantity -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Total Quantity *</label>
                            <div class="relative">
                                <input type="number" name="quantity" value="{{ old('quantity', $equipment->quantity) }}" min="0" required
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-50 transition outline-none">
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Available -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Available *</label>
                            <div class="relative">
                                <input type="number" name="available" value="{{ old('available', $equipment->available) }}" min="0" required
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-50 transition outline-none">
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Section -->
                <div class="p-8 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="w-1 h-5 bg-purple-600 rounded-full"></div>
                        Specifications
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Size/Spec -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Size / Specification</label>
                            <input type="text" name="size" value="{{ old('size', $equipment->size) }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition outline-none">
                        </div>

                        <!-- Hazard Code -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hazard Code</label>
                            <input type="text" name="hazard_code" value="{{ old('hazard_code', $equipment->hazard_code) }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition outline-none">
                        </div>
                        <!-- status -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <input type="text" name="status" value="{{ old('status', $equipment->status) }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition outline-none">
                        </div>
                    </div>
                </div>
                
                <!-- Image Section -->
                <div class="p-8 bg-gradient-to-br from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="w-1 h-5 bg-orange-600 rounded-full"></div>
                        Equipment Image
                    </h2>
                    
                    @if($equipment->image_path)
                        <div class="mb-6 inline-flex items-center gap-4 p-4 bg-white rounded-xl border-2 border-gray-200">
                            <img src="{{ asset('storage/' . $equipment->image_path) }}" 
                                 class="h-20 w-20 object-cover rounded-lg shadow-sm">
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Current Image</p>
                                <p class="text-xs text-gray-500 mt-1">Upload a new image to replace</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="relative group">
                        <input type="file" name="image_path" id="image_path"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="flex items-center justify-center w-full px-6 py-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-orange-400 transition group-hover:bg-orange-50/50 cursor-pointer">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium text-gray-700">Click to upload new image</p>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-8 bg-gray-50 flex justify-end gap-4">
                    <button type="submit" 
                            class="w-full px-6 py-4 rounded-xl shadow-lg bg-scilab-blue text-white font-bold text-lg hover:opacity-90 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>