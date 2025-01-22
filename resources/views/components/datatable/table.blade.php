@props([
    'total' => 0,
])
<div>
    <div class="w-full rounded-lg shadow-xs  min-w-[800px] ">
        <div class="">
            <table class="w-full whitespace-no-wrap border-4 dark:border-gray-600 border-double scroll">
                <div class="w-full">
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
