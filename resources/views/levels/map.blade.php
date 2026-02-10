<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Aprende Python
        </h1>

        <div class="grid grid-cols-2 gap-6">
            @foreach ($levels as $level)
                @php
                    $status = $userLevels[$level->id] ?? 'locked';
                @endphp

                <div class="level-card {{ $status }}">
                    <h2 class="font-semibold">{{ $level->title }}</h2>
                    <p class="text-sm text-gray-600">{{ $level->description }}</p>

                    <span class="status">{{ $status }}</span>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
