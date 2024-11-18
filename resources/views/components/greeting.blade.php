<!-- resources/views/components/greeting.blade.php -->
<div class="mb-6 text-gray-900">
    <div class="flex items-center justify-between">
        <!-- Left Section: Greeting and Profile Picture -->
        <div class="flex items-center space-x-4">
            @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full">
                                @else
                                    <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" class="w-32 h-32 rounded-full object-cover">
                                @endif
            <div>
                <p class="text-2xl font-semibold">{{ __("Hey, " . Auth::user()->name) }}</p>
                <p class="text-gray-600">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <!-- Right Section: Search Input and Icons -->
        <div class="flex items-center space-x-4">
            <!-- Search Form -->
            <form class="flex items-center">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari" 
                    class="px-4 py-2 border rounded-3xl border-pink-900 focus:outline- focus:border-white"
                >
                <button type="submit" class="ml-2 px-4 py-2 bg-pink-800 text-white rounded-3xl hover:bg-pink-900">
                    Search
                </button>
            </form>

            <!-- Settings Icon -->
            <a href="#" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 0110 10 10 10 0 01-10 10A10 10 0 012 12a10 10 0 0110-10zm-2 10h4m0 0V6m0 4v8" />
                </svg>
            </a>

            <!-- Profile Icon -->
            <a href="{{route('admin.profile')}}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 110 8 4 4 0 010-8zm0 8c-5.523 0-10 2.239-10 5v2h20v-2c0-2.761-4.477-5-10-5z" />
                </svg>
            </a>
        </div>
    </div>
</div>
