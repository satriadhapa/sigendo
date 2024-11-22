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
                            <h2 class="welcome-heading rounded ">{{ __("Edit Data Dosen") }}</h2>
                        </div>

                        <!-- Edit Lecturer Form -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <form action="{{ route('admin.lecturers.update', $lecturer->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="name">Nama</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $lecturer->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $lecturer->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </div>

                                <!-- NIP Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="nomor_induk_pegawai">NIP</label>
                                    <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" value="{{ old('nomor_induk_pegawai', $lecturer->nomor_induk_pegawai) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </div>

                                <!-- Academic Position Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="jabatan_akademik">Jabatan Akademik</label>
                                    <input type="text" name="jabatan_akademik" id="jabatan_akademik" value="{{ old('jabatan_akademik', $lecturer->jabatan_akademik) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </div>

                                <!-- Study Program Field -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="program_studi_id">Program Studi</label>
                                    <select name="program_studi_id" id="program_studi_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                        @foreach($programStudies as $programStudy)
                                            <option value="{{ $programStudy->id }}" {{ $lecturer->program_studi_id == $programStudy->id ? 'selected' : '' }}>
                                                {{ $programStudy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="mt-6">
                                    <button type="submit" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.lecturers.index') }}" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                        Kembali
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
