@props(['disabled' => false, 'withError' => false])

<input data-ripple-light="true" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs',
]) !!}>
@if ($withError)
    @error($withError)
        <h6 class=" text-red-500 p-1">
            {{ $message }}
        </h6>
    @enderror
@endif
