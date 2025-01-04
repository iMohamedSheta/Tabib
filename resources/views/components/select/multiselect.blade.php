@props(['items' => [], 'withError' => false, 'label' => 'اختر العناصر'])

<div x-data="multiSelect('{{ json_encode($items, true) }}')" class="relative block">
    <!-- Selected Tags Display -->
    <div {!! $attributes->merge([
        'class' => 'flex flex-wrap gap-1 border  p-2 cursor-pointer w-full  bg-gray-200  dark:text-gray-500 focus:outline-none focus:shadow-outline-purple
            border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm
            dark:focus:shadow-outline-gray form-input',
    ]) !!} {{ $attributes->except('class') }} @click="toggleDropdown">
        <template x-for="(option, index) in selectedOptions" :key="index">
            <span class="bg-purple-600 text-white px-2  rounded flex items-center space-x-1">
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
        class="absolute z-10 w-full bg-gray-200 text-gray-700 border rounded shadow-lg mt-1">
        <template x-for="(option, index) in options" :key="index">
            <div @click="toggleOption(option)" :class="{ 'bg-purple-100': isSelected(option) }"
                class="px-4 py-2 hover:bg-purple-50 cursor-pointer flex justify-between items-center">
                <span x-text="option"></span>
                <span x-show="isSelected(option)" class="text-purple-600 font-semibold">✓</span>
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
