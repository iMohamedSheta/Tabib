@props([
    'name' => 'actions',
])
<td class=" flex items-center justify-center group my-4" x-data="actions()" >
    <div  class="flex items-center justify-center bg-purple-500 hover:bg-purple-600 dark:bg-gray-800 rounded-full" >
            <div class="relative flex items-center space-x-4 text-sm " >
                <button  @click="toggleActionsMenu()"
                        class="flex items-center group-hover:text-purple-100 justify-between p-4  text-sm font-medium leading-5 text-purple-100 rounded-lg
                        dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="actions">
                        <i class="fa fa-cog fa-lg "></i>
                <span class=" px-2">
                    {{ $name}}
                </span>
                </button>
                <!-- Dropdown Menu -->
                <div x-show="showDropdown"
                    style="display: none;"
                    @click.away="showDropdown = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute top-50 right-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg z-[999]">
                    <div class="absolute left-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700">
                        {{ $slot }}
                    </div>
                </div>
            </div>
    </div>
</td>

@push('scripts')
    <script>
        function actions() {
            return {
                showDropdown: false,
                toggleActionsMenu() {
                    this.showDropdown = !this.showDropdown;
                }
            }
        }
    </script>
@endpush
