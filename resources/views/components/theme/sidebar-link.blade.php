@props([
    'activeRoute' => false,
])

<li class="relative ">
    @isRoute($activeRoute)
        <!-- Active items have the snippet below -->
        <span class="absolute inset-y-0 right-0 w-1 bg-gray-300 dark:bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
    @endIsRoute
    <button wire:navigate wire:loading.attr="disabled"
        class="inline-flex items-center px-6 py-4 dark:text-gray-400 text-purple-200 hover:bg-purple-500 hover:text-white  w-full text-sm font-semibold transition-colors duration-150
        {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }}>
        <span>
            {{ $icon }}
        </span>
        <span :class="{ 'hidden': isAppSidebarClosed }">
            {{ $slot }}
        </span>
    </button>
</li>
