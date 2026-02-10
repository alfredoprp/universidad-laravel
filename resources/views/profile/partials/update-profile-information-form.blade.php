<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Información de Perfil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __("Actualiza la información de tu cuenta de perfil y dirección de email.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div class="space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                
                <div class="mt-4">
                    <x-input-label for="avatar" :value="__('Foto de Perfil')" class="text-gray-300" />
                    <input id="avatar" name="avatar" type="file" onchange="previewImage(event)"
                        class="mt-1 block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-600 file:text-white
                            hover:file:bg-indigo-700
                            cursor:pointer" />
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>

            <div class="flex flex-col items-center justify-center p-4 border-l border-gray-700">
                <x-input-label :value="__('Vista previa')" class="mb-4 text-gray-400" />
                <div class="relative">
                    <img id="img-preview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}" 
                        class="{{ $user->avatar ? '' : 'hidden' }} w-48 h-48 rounded-full object-cover border-4 border-indigo-600 shadow-lg shadow-indigo-500/20">
                    
                    <div id="no-photo" class="{{ $user->avatar ? 'hidden' : '' }} w-48 h-48 rounded-full bg-gray-700 flex items-center justify-center border-4 border-dashed border-gray-600">
                        <span class="text-gray-500">Sin foto</span>
                    </div>
                </div>
            </div>
        </div>
                    
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-400">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('img-preview');
        const noPhotoPlaceholder = document.getElementById('no-photo');

        reader.onload = function() {
            if (reader.readyState === 2) {
                imageField.src = reader.result;
                imageField.classList.remove('hidden');
                if (noPhotoPlaceholder) {
                    noPhotoPlaceholder.classList.add('hidden');
                }
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
