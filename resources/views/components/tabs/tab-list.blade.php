@props([
    'selectedTab' => '',
])
<div x-data="{ selectedTab: '{{ $selectedTab }}' }" class="w-full">
    <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()"
        class="flex  items-center gap-2 overflow-x-auto border-b border-gray-500 border-neutral-300  dark:border-neutral-700"
        role="tablist" aria-label="tab options">
        {{ $tabs }}
    </div>
    {{ $slot }}
</div>
