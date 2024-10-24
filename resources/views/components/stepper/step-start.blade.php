@props([
    'active' => false,
    'nextIsActive' => true,
    'done' => false,
    'title' => 'العنوان',
    'icon' => null
])

<ol class="overflow-hidden space-y-8">
<li class="relative flex-1 after:content-[''] after:w-0.5 after:h-full {{ $active || $nextIsActive ? 'after:bg-purple-700' : 'after:bg-gray-200' }} after:inline-block after:absolute after:-bottom-11 after:left-1/2 shadow-lg">
    <div class="flex items-center justify-center gap-8 w-full max-w-sm">
        <div class="flex items-center gap-3.5  {{ $active ? 'bg-purple-50 border-purple-600' : 'bg-gray-50 border-gray-50' }} p-3.5 rounded-xl relative z-10 border w-full">
            @if ($done)
                <div class="rounded-lg bg-green-600 flex items-center justify-center ">
                    <span class=" text-gray-200 py-3 px-4">
                        <i class="fa-solid fa-circle-check fa-lg fa-beat"></i>
                    </span>
                </div>
            @else
                <div class="rounded-lg {{ $active ? 'bg-purple-600' : 'bg-gray-200' }} flex items-center justify-center">
                    <span class="{{ $active ? 'text-white' : 'text-gray-600' }} p-3">
                        @if ($icon)
                            {{ $icon }}
                        @endif
                    </span>
                </div>
            @endif
            <div class="flex items-start rounded-md justify-center flex-col">
                <h6 class="text-base font-semibold text-black mb-0.5">
                    {{ $title }}
                </h6>
                <p class="text-xs font-normal text-gray-500">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</li>
