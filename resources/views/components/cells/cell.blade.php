@props([
    'label' => 'label',
    'border' => true,
    'isText' => false,
    'minHeight' => '50px',
])

<div class="w-full {{ $isText ? "min-h-[{$minHeight}]" : 'md:w-1/2 h-[50px]' }} bg-purple-700">
    <div class="flex flex-wrap justify-center items-center h-full">
        <div
            class="w-full {{ $isText ? 'md:w-1/6' : 'md:w-1/3' }}  bg-c-gray-700 h-full flex  items-center text-purple-100 px-6 {{ $border ? 'border-t' : '' }}">
            {{ $label }}
        </div>
        <div
            class="w-full {{ $isText ? 'md:w-5/6' : 'md:w-2/3' }}  md:w-2/3 bg-purple-200 h-full flex  items-center {{ $border ? 'border-t border-c-gray-700' : '' }}  text-c-gray-700 p-6 rounded-r hover:bg-purple-300 transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
            @if ($slot->isEmpty())
                <span class="text-gray-500 select-none">
                    {{ App\Enums\Helpers\HelperEnum::NOT_AVAILABLE->label() }}
                </span>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>
