<!-- resources/views/jam_kuliah_admin.blade.php -->
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

                        <!-- Title and Add Lecture Hour Button -->
                        <div class="welcome-container">
                            <h2 class="welcome-heading">{{ __("Daftar Jam Kuliah") }}</h2>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('admin.jamkuliah.create') }}" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                + Tambah Jam Kuliah
                            </a>
                        </div>

                        <!-- Lecture Hours Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">No</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Jam Kuliah</th>
                                        {{-- <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Jam Selesai</th> --}}
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lectureHours as $index => $hour)
                                        <tr class="border-b">
                                            <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                                            <td class="py-2 px-4 text-center">{{ $hour->start_time }} - {{ $hour->end_time }}</td>
                                            {{-- <td class="py-2 px-4 text-center">{{ $hour->end_time }}</td> --}}
                                            <td class="py-2 px-4 text-center space-x-2">
                                                <a href="{{ route('admin.jamkuliah.edit', $hour->id) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <form action="{{ route('admin.jamkuliah.destroy', $hour->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this lecture hour?')" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
                                                        <i class="fas fa-trash-alt"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $lectureHours->links() }}
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
