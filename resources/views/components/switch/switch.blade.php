@props(['withError' => false, 'label' => false])
<div>
    <div class="relative inline-block" dir="ltr">
        <input type="checkbox" {{ $attributes->except('class') }}
            class="peer relative w-11 h-6 p-px bg-gray-100 focus:ring-0 focus:ring-offset-0
        border-none text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200
        disabled:opacity-50 disabled:pointer-events-none checked:bg-none
        checked:text-purple-600  dark:bg-gray-300 shadow-lg dark:checked:bg-purple-500
        before:inline-block before:size-5 before:translate-x-0 checked:before:translate-x-full before:rounded-full
        before:shadow before:transform  before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-purple-200">
        <label for="hs-small-switch-with-icons" class="sr-only">{{ $label ?? 'switch' }}</label>
        <span
            class="peer-checked:text-white text-gray-300 size-5 absolute top-[3px] start-0.5 flex justify-center items-center pointer-events-none transition-colors ease-in-out duration-200 dark:text-neutral-500">
            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </span>
        <span
            class="peer-checked:text-purple-900 text-gray-500 size-5 absolute top-[3px] end-0.5 flex justify-center items-center pointer-events-none transition-colors ease-in-out duration-200 dark:text-neutral-500">
            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </span>
        @if ($withError)
            @error($withError)
                <h6 class="text-sm text-red-500 p-1">
                    {{ $message }}
                </h6>
            @enderror
        @endif
    </div>
    @if ($label)
        <label for="" class="font-medium text-sm text-gray-700 px-1">
            {{ $label }}
        </label>
    @endif
</div>
