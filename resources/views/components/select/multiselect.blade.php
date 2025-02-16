@props(['items' => [], 'withError' => false, 'label' => 'اختر العناصر'])

<div x-data="multiSelect('{{ json_encode($items, true) }}')" class="relative block">
    <!-- Selected Tags Display -->
    <div {!! $attributes->merge([
        'class' => 'flex flex-wrap gap-1 p-2 cursor-pointer border-0 w-full dark:text-gray-500
                                        rounded-sm shadow-sm
                                        form-input',
    ]) !!} {{ $attributes->except('class') }} @click="toggleDropdown">
        <template x-for="(option, index) in selectedOptions" :key="index">
            <span class="bg-purple-600 text-white px-2  rounded-sm flex items-center space-x-1">
                <span x-text="option"></span>
                <button type="button" @click.stop="removeOption(option)"
                    class="text-white font-bold px-1">&times;</button>
            </span>
        </template>
        <span x-show="selectedOptions.length === 0" class="text-gray-400">
            {{ $label }}
        </span>
        <div class="mr-auto">
            <button type="button" class="text-gray-400" @click.stop="toggleDropdown">
                <i :class="dropdownOpen ? 'rotate-180' : ''" class="fa fa-caret-down transition-all py-1 px-2 "></i>
            </button>
        </div>
    </div>

    <!-- Dropdown Options -->
    <div x-show="dropdownOpen" @click.outside="closeDropdown"
        class="absolute z-10 w-full bg-c-gray-700  text-gray-300 rounded-sm shadow-lg mt-1">
        <template x-for="(option, index) in options" :key="index">
            <div @click="toggleOption(option)" :class="{ 'bg-c-gray-600': isSelected(option) }"
                class="px-4 py-2  cursor-pointer flex justify-between items-center">
                <span x-text="option"></span>
                <span x-show="isSelected(option)" class="text-purple-500 font-semibold">✓</span>
            </div>
        </template>
    </div>
</div>

@push('scripts')
    <script>
        function multiSelect(items) {
            return {
                dropdownOpen: false,
                selectedOptions: [],
                options: JSON.parse(items),
                toggleDropdown() {
                    this.dropdownOpen = !this.dropdownOpen;
                },
                closeDropdown() {
                    this.dropdownOpen = false;
                },
                toggleOption(option) {
                    if (this.isSelected(option)) {
                        this.selectedOptions = this.selectedOptions.filter(
                            (selected) => selected !== option
                        );
                    } else {
                        this.selectedOptions.push(option);
                    }
                },
                removeOption(option) {
                    this.selectedOptions = this.selectedOptions.filter(
                        (selected) => selected !== option
                    );
                },
                isSelected(option) {
                    return this.selectedOptions.includes(option);
                },
            };
        }
    </script>
@endpush
