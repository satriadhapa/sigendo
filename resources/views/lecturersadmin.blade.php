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
                            <h2 class="welcome-heading">{{ __("Daftar Dosen") }}</h2>
                        </div>

                        <!-- Lecturers Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">No</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Nama</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">NIP</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Jabatan Akademik</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Program Studi</th>
                                        <th class="py-2 px-4 border-b text-center text-gray-800 font-semibold">Email</th>
                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lecturers as $index => $lecturer)
                                        <tr class="border-b">
                                            <td class="py-2 px-4 text-center">{{ $index + 1 + ($lecturers->currentPage() - 1) * $lecturers->perPage() }}</td>
                                            <td class="py-2 px-4 text-center">{{ $lecturer->name }}</td>
                                            <td class="py-2 px-4 text-center">{{ $lecturer->nomor_induk_pegawai }}</td>
                                            <td class="py-2 px-4 text-center">{{ $lecturer->jabatan_akademik }}</td>
                                            <td class="py-2 px-4 text-center">{{ $lecturer->programStudi->name ?? 'Tidak ada data' }}</td>
                                            <td class="py-2 px-4 text-center">{{ $lecturer->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $lecturers->links() }}
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
