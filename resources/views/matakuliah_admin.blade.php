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

                        <!-- Program Studi Selection Boxes -->
                        <div class="welcome-container">
                            <h2 class="welcome-heading">{{ __("Program Studi") }}</h1>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                            @foreach($programStudies as $program)
                                <a href="{{ route('admin.matakuliah.byProgramStudi', $program->id) }}" 
                                   class="text-center py-2 px-3 rounded-lg hover:bg-pink-800 {{ isset($programStudi) && $programStudi->id === $program->id ? 'bg-pink-900 text-white' : 'bg-gray-400 text-white' }}">
                                    {{ $program->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Show Add Button and Table Only if Program Studi is Selected -->
                        @if(isset($programStudi))
                            <!-- Add Data Button -->
                            <div class="mb-4">
                                <a href="{{ route('admin.matakuliah.create') }}" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                    + Tambah Data
                                </a>
                            </div>

                            <!-- Table of Mata Kuliah Data -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">No</th>
                                            <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Nama Mata Kuliah</th>
                                            <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">SKS</th>
                                            <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Kode</th>
                                            <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mataKuliah as $index => $mata)
                                            <tr class="border-b">
                                                <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                                                <td class="py-2 px-4 text-center">{{ $mata->name }}</td>
                                                <td class="py-2 px-4 text-center">{{ $mata->sks }}</td>
                                                <td class="py-2 px-4 text-center">{{ $mata->kode }}</td>
                                                <td class="py-2 px-4 text-center space-x-2">
                                                    <a href="{{ route('admin.matakuliah.edit', $mata->id) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.matakuliah.destroy', $mata->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this data?')" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
                                                            <i class="fas fa-trash-alt"></i>Hapus
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
                                {{ $mataKuliah->links() }}
                            </div>
                        @endif
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
