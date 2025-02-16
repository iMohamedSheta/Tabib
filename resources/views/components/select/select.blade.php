@props(['label', 'items', 'withError' => false])
<label class="block  ">
    <select {!! $attributes->merge([
        'class' => 'block w-full  text-xs  dark:text-gray-300 focus:outline-none focus:shadow-outline-purple
                                            border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm
                                            dark:focus:shadow-outline-gray form-input px-8',
    ]) !!} {{ $attributes->except('class') }}>
        <option value="">
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
