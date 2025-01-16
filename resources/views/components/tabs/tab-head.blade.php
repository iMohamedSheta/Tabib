@props(['name'])
<button @click="selectedTab = '{{ $name }}'" :aria-selected="selectedTab === '{{ $name }}'"
    :tabindex="selectedTab === '{{ $name }}' ? '0' : '-1'"
    :class="selectedTab === '{{ $name }}' ?
        'font-bold  border-b-2 border-black dark:border-white' :
        'text-neutral-300 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-200'"
    class="flex h-min items-center gap-2 px-4 py-4  text-sm" type="button" role="tab"
    aria-controls="tab-panel-{{ $name }}">
    {{ $slot }}
</button>
