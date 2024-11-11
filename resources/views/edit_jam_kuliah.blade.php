<!-- resources/views/edit_jam_kuliah.blade.php -->
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

                        <!-- Title -->
                        <div class="welcome-container">
                            <h2 class="welcome-heading">{{ __("Edit Jam Kuliah") }}</h2>
                        </div>

                        <!-- Edit Lecture Hour Form -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <form action="{{ route('admin.jamkuliah.update', $lectureHour->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Start Time Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="start_time">Waktu Mulai</label>
                                    <input type="time" name="start_time" id="start_time" value="{{ $lectureHour->start_time }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>

                                <!-- End Time Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="end_time">Waktu Selesai</label>
                                    <input type="time" name="end_time" id="end_time" value="{{ $lectureHour->end_time }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6">
                                    <button type="submit" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        Update Jam Kuliah
                                    </button>
                                    <a href="{{route('admin.jamkuliah.index')}}"><button type="button" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        Kembali
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

<style>
    .welcome-container {
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border-radius: 1.5rem;
        text-align: center;
    }
    .welcome-heading {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background-color: #ebebeb;
        padding: 1.5rem;
        color: rgb(0, 0, 0);
    }
</style>
