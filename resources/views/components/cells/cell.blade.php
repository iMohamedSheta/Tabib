@props([
    'label' => 'label',
    'border' => true,
])

<div class="w-full md:w-1/2 bg-purple-700 h-[50px]">
    <div class="flex flex-wrap justify-center items-center h-full">
        <div
            class="w-full md:w-1/3 bg-c-gray-700 h-full flex  items-center text-purple-100 px-6 {{ $border ? 'border-t' : '' }}">
            {{ $label }}
        </div>
        <div
            class="w-full md:w-2/3 bg-purple-200 h-full flex  items-center {{ $border ? 'border-t border-c-gray-700' : '' }}  text-c-gray-700 px-6 rounded-r hover:bg-purple-300 transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
            {{ $slot->isEmpty() ? App\Enums\Helpers\HelperEnum::NOT_AVAILABLE->label() : $slot }}
        </div>
    </div>
</div>
