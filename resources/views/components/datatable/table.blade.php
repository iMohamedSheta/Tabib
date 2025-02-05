@props([
    'total' => 0,
])
<div>
    <div class="w-full rounded-lg shadow-xs">
        <div class="w-full overflow-auto scroll-apply max-w-full">
            <table class="w-full whitespace-no-wrap border-4 dark:border-gray-600 border-double ">
                <div class="w-full relative">
                    {{ $thead }}
                    {{ $tbody }}
                </div>
            </table>
            @if ($total == 0)
                <x-datatable.tempty></x-datatable.tempty>
            @endif
        </div>
    </div>
</div>
