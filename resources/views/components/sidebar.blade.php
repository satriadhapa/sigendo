<!-- resources/views/components/sidebar.blade.php -->
<div class="bg-gray-400 text-black w-64 p-6 flex flex-col mr-5">
    <!-- Logo Section -->
    <div class="flex items-center mb-8">
        <a href="{{route('admin.dashboard.index')}}"><img src="{{ URL('storage/nusaputra.png') }}" alt="Logo" class="h-11 w-11 mr-4 rounded"></a>
        <a href="{{route('admin.dashboard.index')}}"><span class="text-3xl font-semibold">SiGENDO</span></a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex flex-col space-y-4 text-lg">
        <a href="{{ route('admin.dashboard.index') }}"
           class="p-3 rounded-full {{ request()->routeIs('admin.dashboard.index') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Dashboard
        </a>
        <a href="{{ route('admin.profile') }}"
           class="p-3 rounded-full {{ request()->routeIs('admin.profile') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Profile
        </a>
        <a href="{{route('admin.programstudi')}}"
           class="p-3 rounded-full {{ request()->routeIs('admin.programstudi') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Program Studi
        </a>
        <a href="#"
           class="p-3 rounded-full {{ request()->is('dosen') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Dosen
        </a>
        <a href="{{route('admin.matakuliah')}}"
           class="p-3 rounded-full {{ request()->routeIs('admin.matakuliah') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Mata Kuliah
        </a>
        <a href="{{route('admin.ruangan.index')}}"
           class="p-3 rounded-full {{ request()->routeIs('admin.ruangan.index') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Ruangan
        </a>
        <a href="{{route('admin.jamkuliah.index')}}"
           class="p-3 rounded-full {{ request()->routeIs('admin.jamkuliah.index') ? 'bg-pink-900 text-white' : 'hover:bg-pink-900' }} text-center">
            Jam Kuliah
        </a>
    </nav>

    <!-- Logout Button at the Bottom -->
    <div class="mt-auto pt-4 border-t border-gray-600">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="bg-pink-900 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full text-lg">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
