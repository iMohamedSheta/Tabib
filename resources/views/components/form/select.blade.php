@props(['label', 'items', 'withError' => false])
<label class="block  my-2">
    <select
        class="block w-full  mt-2  dark:border-gray-600 dark:bg-gray-700 focus:border-purple-200 rounded-lg focus:outline-none focus:shadow-outline-purple dark:text-gray-300
        dark:focus:shadow-outline-gray form-input
        {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }}>
        <option>
            {{ $label }}
        </option>
        @foreach ($items as $key => $value)
            <option value="{{ $key }}">
                {{ $value }}
            </option>
        @endforeach
    </select>

    @if ($withError)
        @error($withError)
            <h6 class=" text-red-500 p-1">
                {{ $message }}
            </h6>
        @enderror
    @endif
</label>
