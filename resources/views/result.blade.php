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

                    <!-- User Dashboard Content -->
                    <div class="p-6 text-gray-900 text-center font-bold ">
                        <p class="text-3xl">{{ __("Jadwal  " . Auth::user()->name . "!") }}</p>
                        <br>
                        <!-- Tombol Export -->
                        <div class="mb-4">
                            <a href="{{ route('export.schedule') }}" 
                               class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Export to Excel
                            </a>
                            <a href="{{ route('user.dashboard.index') }}" 
                               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Buat Kembali Jadwal
                            </a>
                        </div>
                        
                        <!-- Tombol Setujui -->
                        <form action="{{ route('schedule.approveAll') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Setujui Ruangan
                            </button>
                        </form>
                        @if (session('success'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                        <br>
                        <!-- Tabel Hasil Jadwal -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2">No</th>
                                        <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                                        <th class="border border-gray-300 px-4 py-2">Hari</th>
                                        <th class="border border-gray-300 px-4 py-2">Jam</th>
                                        <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                                        <th class="border border-gray-300 px-4 py-2">Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mappedSchedule as $index => $entry)
                                        <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }}">
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $entry['tanggal'] }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $entry['hari'] }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $entry['jam'] }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $entry['mata_kuliah'] }} - {{ $entry['kelas'] }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $entry['ruangan'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="border border-gray-300 px-4 py-2 text-center">
                                                Tidak ada jadwal yang ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
