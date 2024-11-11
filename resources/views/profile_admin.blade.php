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

                        <!-- Profile Information Section -->
                        <div class="welcome-container">
                            <h1 class="welcome-heading">{{ __("Profile Information") }}</h1>
                        </div>
                        
                        <div class="custom-grid">
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Nama</h2>
                                <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Email</h2>
                                <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Nomor Induk Pegawai</h2>
                                <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->nomor_induk_pegawai ?? 'Not Provided' }}</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Jabatan Akademik</h2>
                                <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->jabatan_akademik ?? 'Not Provided' }}</p>
                            </div>
                            <div class="custom-card">
                                <h2 class="text-xl font-semibold text-gray-700">Program Studi</h2>
                                <p class="text-2xl font-bold text-gray-800">{{ $admin->programStudi->name ?? 'Not Assigned' }}</p>
                            </div>
                        </div>

                        <!-- Button to Open Edit Profile Modal -->
                        <div class="text-center mt-6">
                            <button onclick="openModal()" class="bg-pink-800 hover:bg-pink-900 text-white font-bold py-2 px-4 rounded">
                                Edit Profile
                            </button>
                        </div>

                        <!-- Edit Profile Modal -->
                        <div id="editProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
                            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg relative">
                                <h2 class="text-2xl font-semibold mb-6 text-center">{{ __("Edit Profile Information") }}</h2>
                                
                                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div class="flex flex-col">
                                        <label for="name" class="text-lg font-semibold text-gray-700">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" class="p-2 border border-gray-400 rounded" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="email" class="text-lg font-semibold text-gray-700">Email</label>
                                        <input type="text" name="email" id="email" class="p-2 border border-gray-400 rounded" value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="nomor_induk_pegawai" class="text-lg font-semibold text-gray-700">Nomor Induk Pegawai</label>
                                        <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" class="p-2 border border-gray-400 rounded" value="{{ Auth::user()->nomor_induk_pegawai }}">
                                    </div>

                                    <div class="flex flex-col">
                                        <label for="jabatan_akademik" class="text-lg font-semibold text-gray-700">Jabatan Akademik</label>
                                        <input type="text" name="jabatan_akademik" id="jabatan_akademik" class="p-2 border border-gray-400 rounded" value="{{ Auth::user()->jabatan_akademik }}">
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="program_studi_id" class="text-lg font-semibold text-gray-700">Program Studi</label>
                                        <select name="program_studi_id" id="program_studi_id" class="p-2 border border-gray-400 rounded">
                                            <option value="">Select Program Studi</option>
                                            @foreach ($programStudies as $program)
                                                <option value="{{ $program->id }}" {{ $admin->program_studi_id == $program->id ? 'selected' : '' }}>
                                                    {{ $program->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex justify-end space-x-4 mt-4">
                                        <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-pink-800 hover:bg-pink-900 text-white font-bold py-2 px-4 rounded">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Add JavaScript to handle modal open/close -->
<script>
    function openModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>

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
    .custom-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .custom-card {
        background-color: rgb(235, 235, 235);
        padding: 24px;
        border-radius: 0.5rem;
        text-align: center;
    }
</style>
