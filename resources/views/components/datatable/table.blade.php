@props([
    'total' => 0,
])
<div>
    <div class="w-full rounded-lg shadow-xs">
        <div class="w-full">
            <table class="w-full whitespace-no-wrap overflow-x-auto border-4 dark:border-gray-600 border-double">
                {{ $thead }}
                {{ $tbody }}
            </table>
            @if ($total == 0)
                <x-datatable.tempty></x-datatable.tempty>
            @endif
        </div>
    </div>
</div>
