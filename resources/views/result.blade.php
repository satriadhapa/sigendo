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
                    <div class="p-6 text-gray-900">
                        <p>{{ __("Selamat Datang, " . Auth::user()->name . "!") }}</p>

                        <!-- Tombol Export -->
                        <div class="mb-4">
                            <a href="{{ route('export.schedule') }}" 
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Export to Excel
                            </a>
                        </div>
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">No</th>
                                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                                    <th class="border border-gray-300 px-4 py-2">Jam</th>
                                    <th class="border border-gray-300 px-4 py-2">Kuliah</th>
                                    <th class="border border-gray-300 px-4 py-2">Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule as $index => $entry)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $entry['tanggal'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $entry['hari'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $entry['jam'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $entry['mata_kuliah'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $entry['kelas'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
