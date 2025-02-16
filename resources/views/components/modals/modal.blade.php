@props(['id' => null, 'maxWidth' => null, 'show' => 'show', 'opacity' => 90, 'withPadding' => true])

<x-modals.alpine-modal :id="$id" :show="$show" :opacity="$opacity" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="{{ $withPadding ? 'px-6 py-4' : '' }}">
        @if ($title ?? false)
            <div class="text-lg  font-bold text-gray-900">
                {{ $title }}
            </div>
        @endif

        <div class="mt-4  text-gray-600">
            {{ $content }}
        </div>
    </div>

    @if ($footer ?? false)
        <div class="flex flex-row justify-end {{ $withPadding ? 'px-6 py-4' : '' }}  rounded-b-xl text-end">
            {{ $footer }}
        </div>
    @endif
</x-modals.alpine-modal>
