<a href="#"
    class="inline-flex items-center w-full px-2 py-1 font-semibold transition-colors duration-150 rounded-md  hover:bg-purple-500  dark:hover:bg-gray-800
dark:hover:text-gray-200 {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}>
    {{ $slot }}
</a>
