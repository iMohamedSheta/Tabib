@props([
    'headers' => [],
    'iterator' => false,
    'selector' => false,
    'sorting' => false,
])
<thead>
    <tr
        class="text-xs font-semibold tracking-wide text-center uppercase border-4 bg-gray-100 dark:border-gray-600  dark:text-gray-400 dark:bg-gray-800
            rounded border-double ">
        {{ $slot }}
        @if ($iterator || $selector)
            <th class="px-4 py-3">
                <div>
                    @if ($selector)
                        <div class="flex">
                            <input type="checkbox" id="select-all-header">
                        </div>
                    @endif
                    @if ($iterator)
                        <label class=" px-1">
                            #
                        </label>
                    @endif
                </div>
            </th>
        @endif
        @forelse ($headers as $column => $header)
            <th class="px-4 py-3  min-w-[150px]">
                {{ $header }}
            </th>
        @empty
            <th class="">There is no Columns</th>
        @endforelse
    </tr>
</thead>
