{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot> --}}
<x-app-layout>

    <div class="flex min-h-screen">
        <!-- Main Content with Sidebar Inside -->
        <div class="flex-1 py-12 px-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-gray-500 shadow-sm rounded-lg overflow-hidden">
                    
                    <!-- Sidebar Inside Main Content -->
                    <div class="bg-gray-500 text-black w-64 p-6 flex flex-col">
                        <!-- Logo Section -->
                        <div class="flex items-center mb-8">
                            <!-- Logo -->
                            <img src="{{ URL('storage/nusaputra.png') }}" alt="Logo" class="h-9 w-9 mr-4 rounded-half">
                            <!-- Sigendo Text -->
                            <span class="text-3xl font-semibold">Sigendo</span>
                        </div>

                        <!-- Navigation Links -->
                        <nav class="flex flex-col space-y-4 text-lg">
                            <a href="#" class="hover:bg-gray-700 p-3 rounded">Dashboard</a>
                            <a href="#" class="hover:bg-gray-700 p-3 rounded">Profile</a>
                            <a href="#" class="hover:bg-gray-700 p-3 rounded">Settings</a>
                            <a href="#" class="hover:bg-gray-700 p-3 rounded">Support</a>
                        </nav>

                        <!-- Logout Button at the Bottom -->
                        <div class="mt-auto pt-4 border-t border-gray-700">
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-200 text-white font-bold py-2 px-4 rounded w-full text-lg">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="flex-1 p-6">
                        <!-- Greeting Message -->
                        <div class="mb-6 text-gray-900">
                            <p>{{ __("Selamat Datang " . Auth::user()->name . "!") }}</p>
                        </div>

                        <!-- Additional Content Section -->
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-700">Informasi Terbaru</h2>
                            <p class="text-gray-600">Di sini Anda bisa melihat informasi terbaru dan aktivitas Anda di platform ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>



