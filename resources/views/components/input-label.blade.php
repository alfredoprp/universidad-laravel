@props(['value'])

<<<<<<< HEAD
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
=======
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-100']) }}>
>>>>>>> origin/feature/perfil-oscuro-calendario
    {{ $value ?? $slot }}
</label>
