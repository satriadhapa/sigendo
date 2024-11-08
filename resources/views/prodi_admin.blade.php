<!-- resources/views/prodi_admin.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Main Content with Sidebar -->
        <div class="flex-1 py-12 px-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-gray-300 shadow-sm rounded-lg overflow-hidden">
                    
                    <!-- Include the sidebar component -->
                    @include('components.sidebar')

                    <!-- Main Content Area -->
                    <div class="flex-1 p-6 bg-gray-300">
                        <!-- Greeting Message with Profile Picture and Date -->
                        @include('components.greeting')

                        <!-- Program Studi Section -->
                        <div class="welcome-container">
                            <h1 class="welcome-heading">{{ __("Program Studi") }}</h1>
                        </div>
                        <!-- Add Data Button -->
                        <div class="mb-4">
                            <a href="{{route('admin.programstudi.store')}}" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
                                + Tambah Data
                            </a>
                        </div>
                        <!-- Table of Program Studi Data -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">No</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Kode</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Nama Program Studi</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programStudi as $index => $program)
                                        <tr class="border-b">
                                            <!-- Number Column -->
                                            <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                                            <!-- Program Name Column -->
                                            <td class="py-2 px-4 text-center">{{ $program['kode'] }}</td>
                                            <td class="py-2 px-4 text-center">{{ $program['name'] }}</td>
                                            <!-- Action Buttons -->
                                            <td class="py-2 px-4 text-center space-x-2">
                                                <a href="{{ route('admin.programstudi.edit', $program['id']) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.programstudi.destroy', $program['id']) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this data?')" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

