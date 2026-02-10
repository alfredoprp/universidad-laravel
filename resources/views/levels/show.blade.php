<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 space-y-8">

        <h1 class="text-3xl font-bold text-center text-white">
            {{ $level->title }}
        </h1>

        <!-- Barra de progreso -->
        <div class="w-full bg-gray-700 rounded-full h-3">
            <div
                class="h-3 bg-blue-600 rounded-full transition-all"
                style="width: {{ ($step / 3) * 100 }}%">
            </div>
        </div>

        {{-- ================= PASO 0 ================= --}}
        @if($step == 0)
            <section class="bg-white p-6 rounded-xl">
                <h2 class="text-xl font-bold mb-4">📘 Introducción</h2>
                <p>
                    En Python, una variable es un espacio donde se guarda información.
                </p>

                <form method="POST" action="{{ route('levels.next', $level) }}">
                    @csrf
                    <button class="mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl">
                        Comenzar →
                    </button>
                </form>
            </section>
        @endif

        {{-- ================= PASO 1 ================= --}}
        @if($step == 1)
            <section class="bg-white p-6 rounded-xl">
                <h2 class="text-xl font-bold mb-4">📘 Comprensión</h2>
                <p>
                    Las variables permiten almacenar datos como números, texto o resultados.
                </p>

                <div class="flex justify-between mt-6">
                    <form method="POST" action="{{ route('levels.prev', $level) }}">
                        @csrf
                        <button class="bg-gray-600 text-white px-6 py-3 rounded-xl">
                            ← Volver
                        </button>
                    </form>

                    <form method="POST" action="{{ route('levels.next', $level) }}">
                        @csrf
                        <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                            Continuar →
                        </button>
                    </form>
                </div>
            </section>
        @endif

        {{-- ================= PASO 2 ================= --}}
        @if($step == 2)
            <section class="bg-gray-900 text-green-400 p-6 rounded-xl font-mono">
                <h2 class="text-xl font-bold mb-4 text-white">💡 Ejemplo</h2>

<pre>
x = 10
nombre = "Juan"
print(x)
print(nombre)
</pre>

                <div class="flex justify-between mt-6">
                    <form method="POST" action="{{ route('levels.prev', $level) }}">
                        @csrf
                        <button class="bg-gray-600 text-white px-6 py-3 rounded-xl">
                            ← Volver
                        </button>
                    </form>

                    <form method="POST" action="{{ route('levels.next', $level) }}">
                        @csrf
                        <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                            Continuar →
                        </button>
                    </form>
                </div>
            </section>
        @endif

        {{-- ================= PASO 3 ================= --}}
        @if($step == 3 && $exercise)
            <section class="bg-white p-6 rounded-xl">
                <h2 class="text-xl font-bold mb-4">✏️ Ejercicio</h2>

                <p class="mb-4">{{ $exercise->question }}</p>

                <form method="POST" action="{{ route('levels.complete', $level) }}">
                    @csrf

                    {{-- OPCIÓN MÚLTIPLE --}}
                    @if($exercise->type === 'multiple' && $exercise->options)
                        @foreach ($exercise->options as $option)
                            <label class="block mt-2 cursor-pointer">
                                <input
                                    type="radio"
                                    name="answer"
                                    value="{{ $option }}"
                                    required
                                >
                                {{ $option }}
                            </label>
                        @endforeach
                    @endif

                    {{-- COMPLETAR --}}
                    @if($exercise->type === 'fill')
                        <input
                            type="text"
                            name="answer"
                            class="w-full border p-2 rounded"
                            required
                        >
                    @endif

                    {{-- VERDADERO / FALSO --}}
                    @if($exercise->type === 'true_false')
                        <label class="block mt-2">
                            <input type="radio" name="answer" value="true" required>
                            Verdadero
                        </label>
                        <label class="block mt-2">
                            <input type="radio" name="answer" value="false" required>
                            Falso
                        </label>
                    @endif

                    @if(session('error'))
                        <p class="text-red-600 mt-2">
                            {{ session('error') }}
                        </p>
                    @endif

                    <div class="flex justify-end mt-6">
                        <button class="bg-green-600 text-white px-6 py-3 rounded-xl">
                            Finalizar nivel
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('levels.prev', $level) }}" class="mt-4">
                    @csrf
                    <button class="bg-gray-600 text-white px-6 py-3 rounded-xl">
                        ← Volver
                    </button>
                </form>
            </section>
        @endif

    </div>
</x-app-layout>










