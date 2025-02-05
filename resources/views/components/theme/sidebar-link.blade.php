@props([
    'activeRoute' => false,
])

<li class="relative ">
    @isRoute($activeRoute)
        <!-- Active items have the snippet below -->
        <span class="absolute inset-y-0 right-0 w-4  bg-c-gray-800 rounded-tl-full rounded-bl-lg" aria-hidden="true"></span>
        <span class="absolute inset-y-0 left-0 w-4  bg-purple-400 rounded-tr-lg rounded-br-full" aria-hidden="true"></span>
    @endIsRoute
    <button type="button" data-ripple-light="true" wire:navigate wire:loading.attr="disabled"
        class="inline-flex items-center px-6 py-4 dark:text-gray-400  @isRoute($activeRoute)
bg-purple-500/20  dark:text-white
@endIsRoute hover:bg-purple-400/10 hover:text-white w-full transition-all font-semibold  duration-100
        {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }} :class="{ 'px-8': !$store.appConfig.isAppSidebarOpen }" x-cloak>
        <span>
            {{ $icon }}
        </span>
        <span :class="{ 'hidden': !$store.appConfig.isAppSidebarOpen }" x-cloak>
            {{ $slot }}
        </span>
    </button>
</li>
