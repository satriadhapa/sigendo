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

                        <!-- Schedule Generation Form with Dummy Data -->
                        <form action="{{ route('schedule.generate') }}" method="POST" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @csrf
                            <!-- Probabilitas Cross Over -->
                            <div>
                                <label for="probabilitas_cross_over" class="block font-medium">Probabilitas Cross Over</label>
                                <input type="number" step="0.01" min="0" max="1" name="probabilitas_cross_over" id="probabilitas_cross_over" class="border-gray-300 rounded-lg mt-1 w-full" required>
                            </div>

                            <!-- Jumlah Populasi -->
                            <div>
                                <label for="jumlah_populasi" class="block font-medium">Jumlah Populasi</label>
                                <input type="number" name="jumlah_populasi" id="jumlah_populasi" class="border-gray-300 rounded-lg mt-1 w-full" required>
                            </div>

                            <!-- Probabilitas Mutasi -->
                            <div>
                                <label for="probabilitas_mutasi" class="block font-medium">Probabilitas Mutasi</label>
                                <input type="number" step="0.01" min="0" max="1" name="probabilitas_mutasi" id="probabilitas_mutasi" class="border-gray-300 rounded-lg mt-1 w-full" required>
                            </div>

                            <!-- Jumlah Generasi -->
                            <div>
                                <label for="jumlah_generasi" class="block font-medium">Jumlah Generasi</label>
                                <input type="number" name="jumlah_generasi" id="jumlah_generasi" class="border-gray-300 rounded-lg mt-1 w-full" required>
                            </div>

                            <!-- Jumlah Kelas (Inisialisasi Huruf) -->
                            <div>
                                <label for="jumlah_kelas" class="block font-medium">Jumlah Kelas</label>
                                <input type="text" name="jumlah_kelas" id="jumlah_kelas" class="border-gray-300 rounded-lg mt-1 w-full" placeholder="e.g., A, B, C" required>
                            </div>

                            <!-- Mata Kuliah (Dynamic) -->
                            <div>
                                <label class="block font-medium">Mata Kuliah</label>
                                <div class="mt-1 space-y-2">
                                    @foreach($mata_kuliahs as $mata_kuliah)
                                        <div>
                                            <input type="checkbox" name="mata_kuliah[]" id="mata_kuliah_{{ $mata_kuliah->id }}" value="{{ $mata_kuliah->id }}" class="mr-2">
                                            <label for="mata_kuliah_{{ $mata_kuliah->id }}">{{ $mata_kuliah->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-gray-600">Maksimal memilih 3 mata kuliah.</small>
                            </div>

                            <!-- Hari Mengajar -->
                            <div>
                                <label class="block font-medium">Hari Mengajar</label>
                                <div class="mt-1 space-y-2">
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_senin" value="Senin" class="mr-2">
                                        <label for="hari_senin">Senin</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_selasa" value="Selasa" class="mr-2">
                                        <label for="hari_selasa">Selasa</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_rabu" value="Rabu" class="mr-2">
                                        <label for="hari_rabu">Rabu</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_kamis" value="Kamis" class="mr-2">
                                        <label for="hari_kamis">Kamis</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_jumat" value="Jumat" class="mr-2">
                                        <label for="hari_jumat">Jumat</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_sabtu" value="Sabtu" class="mr-2">
                                        <label for="hari_sabtu">Sabtu</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="hari_mengajar[]" id="hari_minggu" value="Minggu" class="mr-2">
                                        <label for="hari_minggu">Minggu</label>
                                    </div>
                                </div>
                                <small class="text-gray-600">Pilih hari-hari mengajar yang diinginkan.</small>
                            </div>

                            <!-- Tanggal Mulai (Start Date for Scheduling) -->
                            <div>
                                <label for="tanggal_mulai" class="block font-medium">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="border-gray-300 rounded-lg mt-1 w-full" required>
                            </div>

                            <!-- Jam Kuliah (Dynamic) -->
                            <div>
                                <label class="block font-medium">Jam Kuliah</label>
                                <div class="mt-1 space-y-2">
                                    @foreach($jam_kuliahs as $jam_kuliah)
                                        <div>
                                            <input type="checkbox" name="jam_kuliah[]" id="jam_kuliah_{{ $jam_kuliah->id }}" value="{{ $jam_kuliah->id }}" class="mr-2">
                                            <label for="jam_kuliah_{{ $jam_kuliah->id }}">{{ $jam_kuliah->start_time }} - {{ $jam_kuliah->end_time }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-gray-600">Pilih jam yang memungkinkan mengajar.</small>
                            </div>

                            <!-- Ruangan (Dynamic) -->
                            <div>
                                <label class="block font-medium">Ruangan</label>
                                <div class="border border-gray-300 rounded-lg mt-1 p-4">
                                    @foreach($ruangans as $ruangan)
                                        <p class="text-gray-700">{{ $ruangan->name }}</p>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Durasi Jadwal -->
                            <div>
                                <label for="durasi_jadwal" class="block font-medium">Durasi Jadwal (bulan)</label>
                                <input type="number" name="durasi_jadwal" id="durasi_jadwal" class="border-gray-300 rounded-lg mt-1 w-full" placeholder="6 untuk 1 semester" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4 col-span-2">
                                <button type="submit" class="bg-blue-600 text-white rounded-lg py-2 px-4 hover:bg-blue-700">
                                    Buat Jadwal
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
