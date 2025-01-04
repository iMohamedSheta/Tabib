@props(['label', 'withError' => false, 'checked' => false])

<div class="mt-6 ">
    <label class="flex items-center dark:text-gray-400">
        <input type="checkbox" @checked($checked)
            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
            {{ $attributes->get('class') }}"
            {{ $attributes->except('class') }} />

        {{ $slot }}
    </label>
    @if ($withError)
        @error($withError)
            <h6 class=" text-red-500 p-1">
                {{ $message }}
            </h6>
        @enderror
    @endif
</div>
