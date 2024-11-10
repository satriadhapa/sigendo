<x-app-layout>
    <div class="flex min-h-screen">
        <div class="flex-1 py-12 px-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-gray-300 shadow-sm rounded-lg overflow-hidden">

                    <!-- Sidebar Component -->
                    @include('components.sidebar')

                    <!-- Main Content Area -->
                    <div class="flex-1 p-6 bg-gray-300">
                        
                        <!-- Greeting Message with Profile Picture and Date -->
                        @include('components.greeting')
                        
                        <!-- Ruangan Create Form -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h1 class="text-2xl font-bold mb-4">Tambah Ruangan</h1>
                            <form action="{{ route('admin.ruangan.store') }}" method="POST">
                                @csrf
                                
                                <!-- Nama Ruangan Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="name">Nama Ruangan</label>
                                    <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>
                                <!-- Submit Button -->
                                <div class="mt-6">
                                    <button type="submit" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        Tambah Ruangan
                                    </button>
                                    <a href="{{route('admin.ruangan.index')}}"><button type="button" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        kembali
                                    </button>
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
