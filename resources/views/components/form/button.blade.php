<button
    class="block w-full px-4 py-2 mt-4  font-medium leading-5 text-center text-white transition-colors duration-150
    bg-purple-600 border border-transparent rounded-lg active:bg-purple-600
    hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
    {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}>
    {{ $slot }}
</button>
