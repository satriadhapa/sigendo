<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Main Content with Sidebar Inside -->
        <div class="flex-1 py-12 px-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-gray-300 shadow-sm rounded-lg overflow-hidden">
                    
                    <!-- Include the sidebar component -->
                    @include('components.sidebar')


                    <!-- Main Content Area -->
                    <div class="flex-1 p-6 bg-gray-300">
                        <!-- Greeting Message with Profile Picture and Date -->
                        <div class="mb-6 text-gray-900">
                            <div class="flex items-center">
                                <img src="{{ URL('storage/nusaputra.png') }}" alt="Profile Photo" class="h-16 w-16 rounded">
                                <div>
                                    <p class="text-2xl font-semibold">{{ __("Hey, " . Auth::user()->name) }}</p>
                                    <p class="text-gray-600">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Additional Content Section -->
                        <div class="text-center rounded-full">
                            <h1 class="welcome-heading">{{ __("Selamat Datang " . Auth::user()->name ) }}</h1>
                        </div>

                        <style>
                            /* Style untuk div kontainer */
                            .welcome-container {
                                margin-bottom: 1.5rem; 
                                padding: 1.5rem;       
                                border-radius: 1.5rem; 
                                text-align: center;
                            }
                            /* Style untuk judul */
                            .welcome-heading {
                                font-size: 1.8rem;    /* Mirip dengan text-xl */
                                font-weight: 800;      /* Mirip dengan font-semibold */
                                margin-bottom: 1.5rem; /* Mirip dengan mb-6 */
                                background-color: #ebebeb; /* Mirip dengan bg-gray-500 */
                                padding: 1.5rem;       /* Mirip dengan p-6 */
                                color: rgb(0, 0, 0);
                                border-right: none;    /* Mirip dengan border-r-0 */
                            }
                            .custom-grid {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                gap: 24px; /* Mirip dengan gap-6 di Tailwind */
                            }
                            .custom-card {
                                background-color: rgb(235, 235, 235);
                                padding: 24px;
                                border-radius: 0.5rem;
                                text-align: center;
                            }
                        </style>
                        <!-- Dummy Information Cards -->
                        <div class="custom-grid">
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Jumlah Mata Kuliah</h2>
                                <p class="text-4xl font-bold text-gray-800">45</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Jumlah Dosen</h2>
                                <p class="text-4xl font-bold text-gray-800">25</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Jumlah Ruangan</h2>
                                <p class="text-4xl font-bold text-gray-800">12</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Jumlah Program Studi</h2>
                                <p class="text-4xl font-bold text-gray-800">6</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
