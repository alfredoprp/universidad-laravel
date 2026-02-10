<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Menú') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-200 space-y-4">
                    <p>{{ __("Python") }}</p>

                    <!-- Botón para ir al mapa de niveles -->
                    <a href="{{ route('python.map') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none transition">
                        Aprender
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
