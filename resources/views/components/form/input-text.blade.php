@props(['label', 'withError' => false])
<label class="block  mb-4">
    <h4 class="{{ $attributes->get('labelClass') }} text-white  pb-1 "> {{ $label }}</h4>
    <input
        class="block w-full  mt-2  dark:border-gray-600 dark:text-gray-700 focus:border-purple-200 shadow-lg rounded-lg focus:outline-none focus:shadow-outline-purple
             dark:focus:shadow-outline-gray form-input
        {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }} />

    {{ $slot }}
    @if ($withError)
        @error($withError)
            <h6 class=" text-red-500 p-1">
                {{ $message }}
            </h6>
        @enderror
    @endif
</label>
