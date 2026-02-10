<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-10 text-center">
            Aprende Python
        </h1>

        <div class="flex flex-col gap-6">
            @foreach ($levels as $level)
                @php
                    $status = $userLevels[$level->id] ?? 'locked';
                    $isLeft = $loop->index % 2 === 0;
                    $isJustUnlocked = isset($justUnlockedLevelId)
                        && $justUnlockedLevelId === $level->id;
                @endphp

                {{-- 🔒 NIVEL BLOQUEADO --}}
                @if($status === 'locked')
                    <div class="
                        w-72 p-6 rounded-2xl shadow-lg
                        {{ $isLeft ? 'mr-auto ml-20' : 'ml-auto mr-20' }}
                        bg-gray-400 text-gray-700 opacity-60
                    ">
                        <h2 class="font-semibold text-lg">
                            {{ $level->title }}
                        </h2>

                        <p class="text-sm mt-1">
                            {{ $level->description }}
                        </p>

                        <div class="mt-4 text-sm font-semibold">
                            🔒 Bloqueado
                        </div>
                    </div>

                {{-- 🔓 NIVEL DESBLOQUEADO / COMPLETADO --}}
                @else
                    <a href="{{ route('levels.show', $level) }}"
                       class="
                        w-72 p-6 rounded-2xl shadow-lg block
                        {{ $isLeft ? 'mr-auto ml-20' : 'ml-auto mr-20' }}

                        @if($status === 'completed')
                            bg-green-500 text-white
                        @else
                            bg-blue-100 hover:bg-blue-200
                        @endif

                        cursor-pointer hover:scale-105 transition
                        {{ $isJustUnlocked ? 'animate-unlock' : '' }}
                       ">

                        <h2 class="font-semibold text-lg">
                            {{ $level->title }}
                        </h2>

                        <p class="text-sm mt-1">
                            {{ $level->description }}
                        </p>

                        <div class="mt-4 text-sm font-semibold">
                            @if($status === 'completed')
                                ✔ Completado
                            @else
                                ▶ Empezar
                            @endif
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
