<!-- resources/views/components/greeting.blade.php -->
<div class="mb-6 text-gray-900">
    <div class="flex items-center">
        <img src="{{ URL('storage/nusaputra.png') }}" alt="Profile Photo" class="h-16 w-16 rounded">
        <div>
            <p class="text-2xl font-semibold">{{ __("Hey, " . Auth::user()->name) }}</p>
            <p class="text-gray-600">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>
</div>
