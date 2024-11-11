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
                        <h2 class="text-xl font-semibold mb-4">Dashboard User</h2>
                        <p>{{ __("Selamat Datang, " . Auth::user()->name . "!") }}</p>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('auth.logout') }}" class="mt-6">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
