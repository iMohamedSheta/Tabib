<a class="flex items-center justify-center w-full px-4 py-2  font-medium leading-5  text-gray-700 transition-colors
    duration-150 border border-gray-300 rounded-lg dark:text-gray-400 hover:text-gray-200 active:bg-transparent hover:border-gray-500 focus:border-gray-500
    active:text-gray-500 focus:outline-none focus:shadow-outline-gray
        {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}>
    {{ $slot }}
</a>
