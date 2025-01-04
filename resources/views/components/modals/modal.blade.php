@props(['id' => null, 'maxWidth' => null, 'show' => 'show', 'opacity' => 90])

<x-modals.alpine-modal :id="$id" :show="$show" :opacity="$opacity" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg  font-bold text-gray-900">
            {{ $title }}
        </div>

        <div class="mt-4  text-gray-600">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 rounded-b-xl text-end">
        {{ $footer }}
    </div>
</x-modals.alpine-modal>
