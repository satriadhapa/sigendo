<x-app-layout>
    <div class="flex min-h-screen">
        @include('components.sidebar_user')
        <div class="flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    @include('components.greeting_user')

                    <div class="p-6 text-gray-900">
                        <h2 class="text-lg font-semibold">Generated Schedule</h2>

                        @if($generatedSchedule)
                            <table class="min-w-full bg-white border border-gray-300 mt-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b">Tanggal</th>
                                        <th class="py-2 px-4 border-b">Hari</th>
                                        <th class="py-2 px-4 border-b">Jam Mulai</th>
                                        <th class="py-2 px-4 border-b">Jam Selesai</th>
                                        <th class="py-2 px-4 border-b">Kuliah</th>
                                        <th class="py-2 px-4 border-b">Ruang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($generatedSchedule as $schedule)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $schedule['date']->format('d-M-Y') }}</td>
                                            <td class="py-2 px-4 border-b">{{ $schedule['day'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $schedule['start_time'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $schedule['end_time'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $schedule['subject_code'] }} - {{ $schedule['subject_name'] }} ({{ $schedule['class_code'] }})</td>
                                            <td class="py-2 px-4 border-b">{{ $schedule['room'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No schedule generated.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
