@props([
    'name' => 'actions',
    'isTable' => true
])
<div x-data="actions()" class="hover:cursor-pointer" @click="toggleActionsMenu()">
    <td class="flex items-center justify-center group my-4"  x-data="actions()" @if($isTable) @click="toggleActionsMenu()" @endif >
        <div class="relative bg-c-gray-700 rounded-full">
                        <div  class="flex relative  items-center justify-center  " >
                            <div class=" w-full bg-purple-500 hover:bg-purple-600  dark:bg-gray-800 rounded-full transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
                                <button
                                    class="flex w-full items-center group-hover:dark:text-white group-hover:text-purple-100 justify-center p-4  text-sm font-medium leading-5 text-purple-100 rounded-lg
                                        focus:outline-none focus:shadow-outline-gray "
                                    aria-label="actions">
                                    <i class="fa fa-cog fa-lg "></i>
                                <span class=" px-2">
                                    {{ $name}}
                                </span>
                            </button>
                            </div>
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
                            class="absolute top-50 right-50 w-48 mt-2 origin-top-right rounded-md shadow-lg z-[999] ">
                            <div class="absolute  @if(!$isTable) right-[-10px] top-[-165px] @else right-[-10px] top-[20px] @endif dark:opacity-90 w-56 p-2 mt-2 space-y-2 text-purple-100 bg-purple-600 opacity-90 border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
            </div>
    </td>
</div>

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
