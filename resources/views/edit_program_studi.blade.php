<!-- resources/views/edit_program_studi.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen">
        <div class="flex-1 py-12 px-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-gray-300 shadow-sm rounded-lg overflow-hidden">
                    
                    <!-- Include the sidebar component -->
                    @include('components.sidebar')

                    <!-- Main Content Area -->
                    <div class="flex-1 p-6 bg-gray-300">
                        <!-- Greeting Message with Profile Picture and Date -->
                        @include('components.greeting')

                        <div class="welcome-container text-center text-3xl font-bold">
                            <h1 class="welcome-heading">{{ __("Edit Program Studi") }}</h1>
                        </div>

                        <!-- Form for Editing Program Studi -->
                        <form action="{{ route('admin.programstudi.update', $programStudi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div class="flex flex-col">
                                    <label for="kode" class="text-lg font-semibold text-gray-700">Kode Program Studi</label>
                                    <input type="text" name="kode" id="kode" class="p-2 border border-gray-400 rounded" value="{{ $programStudi->kode }}" required>
                                </div>
                                <div class="flex flex-col">
                                    <label for="name" class="text-lg font-semibold text-gray-700">Nama Program Studi</label>
                                    <input type="text" name="name" id="name" class="p-2 border border-gray-400 rounded" value="{{ $programStudi->name }}" required>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4 mt-6">
                                <a href="{{ route('admin.programstudi') }}" class="bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">Cancel</a>
                                <button type="submit" class="bg-pink-800 hover:bg-pink-900 text-white font-bold py-2 px-4 rounded">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
