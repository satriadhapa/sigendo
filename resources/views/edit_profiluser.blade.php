<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar Component -->
        @include('components.sidebar_user')

        <!-- Main Content Area -->
        <div class="flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <!-- Greeting Message with Profile Picture and Date -->
                    @include('components.greeting_user')

                    <!-- Edit Profile Form -->
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-semibold mb-4">Edit Profil User</h2>

                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>upload file image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <!-- Name Field -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            </div>

                            <!-- Nomor Induk Pegawai Field -->
                            <div class="mb-4">
                                <label for="nomor_induk_pegawai" class="block text-gray-700 font-semibold mb-2">Nomor Induk Pegawai</label>
                                <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" value="{{ $user->nomor_induk_pegawai }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            </div>

                            <!-- Jabatan Akademik Field -->
                            <div class="mb-4">
                                <label for="jabatan_akademik" class="block text-gray-700 font-semibold mb-2">Jabatan Akademik</label>
                                <input type="text" name="jabatan_akademik" id="jabatan_akademik" value="{{ $user->jabatan_akademik }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                            </div>

                            <!-- Program Studi Field -->
                            <div class="mb-4">
                                <label for="program_studi_id" class="block text-gray-700 font-semibold mb-2">Program Studi</label>
                                <select name="program_studi_id" id="program_studi_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                    @foreach ($program_studi as $program)
                                        <option value="{{ $program->id }}" {{ $user->program_studi_id == $program->id ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" class="bg-pink-800 text-white font-semibold py-2 px-4 rounded hover:bg-pink-900">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>