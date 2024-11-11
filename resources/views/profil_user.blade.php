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

                    <!-- Profile Content -->
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-semibold mb-4">Profil User</h2>
                        
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-semibold">Nama</td>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-semibold">Email</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-semibold">Nomor Induk Pegawai</td>
                                    <td class="py-2 px-4 border-b">{{ $user->nomor_induk_pegawai }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-semibold">Jabatan Akademik</td>
                                    <td class="py-2 px-4 border-b">{{ $user->jabatan_akademik }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-semibold">Program Studi</td>
                                    <td class="py-2 px-4 border-b">{{ $user->programStudi->name ?? 'Tidak ada data' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Edit Profile Button -->
                        <div class="mt-6 text-center">
                            <a href="{{ route('user.profile.edit') }}" class="bg-pink-800 hover:bg-pink-900 text-white font-semibold py-2 px-4 rounded">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
