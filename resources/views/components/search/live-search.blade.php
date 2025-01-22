<div class="w-full px-2 mt-4" x-data="{
    selectedItem: '',
    showSearchResults: true,
    searchResultClicked(name, id) {
        this.selectedItem = '@' + name;
        this.showSearchResults = false;
        $refs.inputField.classList.add('text-blue-500', 'font-bold', 'bg-[#1F2937]', 'text-2xl');
        $refs.inputField.value = '@' + name;
        $refs.hiddenField.value = id;
        triggerLivewireInputEvent($refs.hiddenField);
    }
}">
    <label>
        {{ $label }}
        <span class="text-red-600">*</span>
    </label>
    <x-input type="text" x-ref="inputField" wire:model.live.debounce.500ms="{{ $wireModel }}"
        x-on:input="if (selectedItem === '') {
            $refs.hiddenField.value = '';
            $refs.inputField.classList.add('text-gray-500');
            triggerLivewireInputEvent($refs.hiddenField);
        }"
        x-model="selectedItem" x-on:click="showSearchResults = true"
        class="mt-4 px-4 py-2 rounded text-sm {{ !blank($idValue) ? 'text-blue-100 text-2xl font-bold bg-[#1F2937]' : '' }} w-full"
        autocomplete="off" spellcheck="false" />
    <input type="hidden" x-ref="hiddenField" wire:model="{{ $hiddenWireModel }}">
    <ul class="bg-[#111827] rounded-b-2xl" x-show="showSearchResults">
        {{ $slot }}
    </ul>
</div>
