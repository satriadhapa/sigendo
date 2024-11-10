<!-- resources/views/edit_matakuliah.blade.php -->
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
                            <h2 class="welcome-heading">{{ __("Program Studi") }}</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                            @foreach($programStudies as $program)
                                <a href="{{ route('admin.matakuliah.byProgramStudi', $program->id) }}" 
                                   class="text-center py-2 px-3 rounded-lg hover:bg-pink-800 {{ isset($programStudi) && $programStudi->id === $program->id ? 'bg-pink-900 text-white' : 'bg-gray-400 text-white' }}">
                                    {{ $program->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Mata Kuliah Edit Form -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h1 class="text-2xl font-bold mb-4">Edit Mata Kuliah</h1>
                            <form action="{{ route('admin.matakuliah.update', $mataKuliah->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Mata Kuliah Name Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="name">Nama Mata Kuliah</label>
                                    <input type="text" name="name" id="name" value="{{ $mataKuliah->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>
                                
                                <!-- SKS Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="sks">SKS</label>
                                    <input type="text" name="sks" id="sks" value="{{ $mataKuliah->sks }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>

                                <!-- Mata Kuliah Code Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="kode">Kode Mata Kuliah</label>
                                    <input type="text" name="kode" id="kode" value="{{ $mataKuliah->kode }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                </div>

                                <!-- Program Studi Selection -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="program_studi_id">Program Studi</label>
                                    <select name="program_studi_id" id="program_studi_id" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                        <option value="">Pilih Program Studi</option>
                                        @foreach($programStudies as $program)
                                            <option value="{{ $program->id }}" {{ $mataKuliah->program_studi_id == $program->id ? 'selected' : '' }}>
                                                {{ $program->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6">
                                    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">
                                        Update Mata Kuliah
                                    </button>
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
