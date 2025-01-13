@props([
    'activeRoute' => false,
])

<li class="relative ">
    @isRoute($activeRoute)
        <!-- Active items have the snippet below -->
        <span class="absolute inset-y-0 right-0 w-1 bg-gray-300 dark:bg-purple-400 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        <span class="absolute inset-y-0 left-0 w-1 bg-gray-300 dark:bg-purple-400 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
    @endIsRoute
    <button type="button" data-ripple-light="true" wire:navigate wire:loading.attr="disabled"
        class="inline-flex items-center px-6 py-4 dark:text-gray-400  @isRoute($activeRoute)
bg-purple-600 dark:text-white
@endIsRoute hover:bg-purple-500 hover:text-white w-full transition-all font-semibold  duration-200
        {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }} :class="{ 'px-8': isAppSidebarClosed }" x-cloak>
        <span>
            {{ $icon }}
        </span>
        <span :class="{ 'hidden': isAppSidebarClosed }" x-cloak>
            {{ $slot }}
        </span>
    </button>
</li>
