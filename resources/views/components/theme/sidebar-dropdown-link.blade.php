@props([
    'title' => 'title',
    'activeRoutes' => '',
    'icon' => null,
])

<li class="relative" x-data="dataSidebarDropDownMenu()">
    @isRoute($activeRoutes)
        <!-- Active items have the snippet below -->
        <span class="absolute inset-y-0 right-0 w-1 bg-gray-300 dark:bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
    @endIsRoute

    <button
        class="inline-flex items-center px-6 py-4 hover:bg-purple-500  hover:text-white  dark:text-gray-400 text-gray-200 justify-between w-full  font-semibold transition-colors duration-150 "
        @click="togglePagesMenu" aria-haspopup="true">
        <span class="inline-flex items-center">
            @if ($icon)
                <span class="transition-[font-size] duration-500">
                    {{ $icon }}
                </span>
            @endif
            <span class="mr-4 transition-[display] duration-500" :class="{ 'hidden': isAppSidebarClosed }">
                {{ $title }}
            </span>
        </span>
        <svg class="w-4 h-4 transation duration-150" x-cloak :class="isPagesMenuOpen && 'rotate-180'" aria-hidden="true"
            fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="isPagesMenuOpen" style="display: none" class="mr-4 mt-1" x-cloak
        :class="{ 'mr-0': isAppSidebarClosed }" x-transition:enter="transition-all ease-in-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2 max-h-0"
        x-transition:enter-end="opacity-100 transform translate-y-0 max-h-screen"
        x-transition:leave="transition-all ease-in-out duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0 max-h-screen"
        x-transition:leave-end="opacity-0 transform -translate-y-2 max-h-0">
        <ul class="mb-2  overflow-hidden  bg-purple-800 font-medium text-gray-500 rounded-md shadow-inner  dark:text-gray-400 dark:bg-c-gray-900"
            aria-label="submenu">
            {{ $slot }}
        </ul>
    </div>
</li>
