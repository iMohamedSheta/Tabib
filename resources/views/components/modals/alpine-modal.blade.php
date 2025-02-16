@props(['id', 'maxWidth', 'show' => 'show', 'opacity' => 90])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div x-on:close.stop="{{ $show }} = false" x-on:keydown.escape.window="{{ $show }} = false"
    x-show="{{ $show }}" x-cloak id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50  scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
    <div x-show="{{ $show }}" class="fixed inset-0 transform transition-all backdrop-blur-sm"
        x-on:click="{{ $show }} = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-c-gray-800 opacity-25"></div>
    </div>

    <div x-show="{{ $show }}"
        class="mb-6 opacity-{{ $opacity }} {{ $attributes->get('class') }} rounded-sm  shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-trap.inert.noscroll="{{ $show }}" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        {{ $slot }}
    </div>
</div>
