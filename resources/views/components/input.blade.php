@props(['disabled' => false, 'withError' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
@if ($withError)
@error($withError)
    <h6 class="text-sm text-red-500 p-1">
        {{ $message }}
    </h6>
@enderror
@endif
