@props([
    'paginator' => null,
    'items' => [10, 25, 50, 100]
])
@if ($paginator->total() > 0)
    <div class="flex flex-col md:flex-row text-sm justify-between p-4">
        <div role="status" aria-live="polite" class="text-gray-600">
            {!! __('عرض') !!}
            <span class="font-semibold p-1">{{ $paginator->firstItem() }}</span>
            {!! __('الي') !!}
            <span class="font-semibold p-1">{{ $paginator->lastItem() }}</span>
            {!! __('من') !!}
            <span class="font-semibold p-1">{{ $paginator->total() }}</span>
            {!! __('النتائج') !!}
        </div>
    </div>

    <div class="flex justify-between p-4">
        <div class="relative">
            @if ($paginator->total() > min($items))
            {{-- <li class="fa fa-caret-down absolute top-8 left-8"></li> --}}
            <select class ='block w-full text-sm dark:text-gray-500 focus:outline-none focus:shadow-outline-purple
            border-gray-300 bg-purple-200 rounded-full shadow-md ring-0 ring-offset-0
            dark:focus:shadow-outline-gray form-input pr-8' wire:change="setPerPage($event.target.value)">
                <option value="{{ $paginator->perPage() }}" selected>{{ $paginator->perPage() }}</option>
                @foreach ($items as $item)
                    @if ($item != $paginator->perPage())
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endif
                @endforeach
            </select>
            @endif
        </div>

        @if ($paginator->hasPages())
            <div>
                <ul class="flex space-x-2">
                    @if ($paginator->onFirstPage())
                        <li>
                            <button class="btn-gray mx-1 text-xs" disabled>
                                <div wire:loading wire:target="previousPage">
                                    <i class="fa-solid fa-spinner fa-spin-pulse px-2"></i>
                                </div>
                                <i class="fa-solid fa-angles-right px-1"></i>
                                السابق
                            </button>
                        </li>
                    @else
                        <li>
                            <button wire:click="previousPage()" wire:loading.attr="disabled" class="btn-primary mx-1 text-xs">
                                <i class="fa-solid fa-angles-right px-1"></i>
                                السابق
                                <div wire:loading wire:target="previousPage">
                                    <i class="fa-solid fa-spinner fa-spin-pulse px-2"></i>
                                </div>
                            </button>
                        </li>
                    @endif

                    <div class="hidden md:flex">
                        @for ($i = 1; $i < $paginator->lastPage(); $i++)
                            @if ($i == 1 || $i == $paginator->lastPage() || ($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1))
                                <li>
                                    <button wire:click="setPageNumber({{ $i }})" class=" {{ $paginator->currentPage() === $i ? 'btn-primary' : 'btn-gray' }} text-xs mx-1 rounded">
                                        {{ $i }}
                                    </button>
                                </li>
                            @elseif ($i == 2 && $paginator->currentPage() > 4)
                                <li><span class="btn-secondary mx-1 text-xs">...</span></li>
                            @elseif ($i == $paginator->lastPage() - 1 && $paginator->currentPage() < $paginator->lastPage() - 3)
                                <li><span class="btn-secondary mx-1 text-xs">...</span></li>
                            @endif
                        @endfor
                    </div>

                    @if ($paginator->hasMorePages())
                        <li>
                            <button wire:click="nextPage()" wire:loading.attr="disabled" class="btn-primary mx-1 text-xs">
                                <div wire:loading wire:target="nextPage">
                                    <i class="fa-solid fa-spinner fa-spin-pulse px-2"></i>
                                </div>
                                التالي
                                <i class="fa-solid fa-angles-left px-1"></i>

                            </button>
                        </li>
                    @else
                        <li>
                            <button class="btn-gray mx-1 text-xs" disabled>
                                <div wire:loading wire:target="nextPage">
                                    <i class="fa-solid fa-spinner fa-spin-pulse px-2"></i>
                                </div>
                                التالي
                                <i class="fa-solid fa-angles-left px-1"></i>
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
@endif
