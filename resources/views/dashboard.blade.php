<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Menú
        </h2>
    </x-slot>

    @php
        $progress = \App\Models\UserLevel::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->first();

        $step = $progress?->step ?? 0;
        $percentage = ($step / 3) * 100;
    @endphp

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 p-6 rounded-xl space-y-6 text-white">

                <p class="text-lg font-semibold">Python</p>

                <a href="{{ route('python.map') }}"
                   class="inline-block bg-indigo-600 px-6 py-3 rounded-xl">
                    Aprender
                </a>

                <a href="{{ route('learning.continue') }}"
                   class="block bg-gray-900 p-4 rounded-xl">
                    <div class="flex justify-between mb-2">
                        <span>Continuar nivel</span>
                        <span>{{ intval($percentage) }}%</span>
                    </div>

                    <div class="w-full bg-gray-700 h-2 rounded-full">
                        <div class="bg-green-500 h-2 rounded-full"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>

