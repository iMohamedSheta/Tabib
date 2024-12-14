<div>
    @if ($withButton ?? false)
        <button class="btn-primary  mx-2" @click="{{ $showName }} = true">
            <i class="fa-solid fa-pen-to-square px-1"></i>
            اضافة خدمة
        </button>
    @endif
    <div>
        <x-modals.modal @keydown.escape.window="{{ $showName }} = false" x-on:added="show = false"
            show="{{ $showName }}" maxWidth="3xl">
            <x-slot name="title">
                اضافة خدمة
            </x-slot>

            <x-slot name="content">
                <h3 class="pb-2">
                    ادخل بيانات الخدمة
                </h3>
                <div class="flex flex-wrap">
                    <div class="mt-4 w-full  px-2">
                        <label>
                            اسم الخدمة
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="text" id="name" wire:model="name" withError="name"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                            autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/2 px-2">
                        <label>
                            السعر
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="number" id="price" wire:model="price" withError="price"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                            autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-6 w-full md:w-1/2 px-2">
                        <label>
                            العيادة
                        </label>
                        <x-select.select label="جميع العيادات" withError="clinic_id" :items="$clinics"
                            wire:model="clinic_id"
                            class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                        </x-select.select>
                    </div>
                    <div x-data="colorSelector()" class="inline-flex items-center w-full" x-cloak>
                        <div class="w-[90%]">
                            <label for="backgroundColorSelected" class="block font-bold px-3 py-4 ">لون مميز</label>
                            <input id="backgroundColorSelected" x-ref="colorInput" type="text"
                                placeholder="Pick a color"
                                class="border-gray-300  focus:border-indigo-500 mx-3 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm"
                                readonly wire:model="color">
                        </div>
                        <div class="relative ml-3 mt-8">
                            <button x-ref="colorButton" type="button"
                                @click="isBackgroundColorsOpen = !isBackgroundColorsOpen"
                                class="w-10 h-10 mx-5 mt-5   rounded-full focus:outline-none focus:shadow-outline inline-flex p-2 shadow"
                                :style="`background: ${backgroundColorSelected}; color: white`">
                                <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path fill="none"
                                        d="M15.584 10.001L13.998 8.417 5.903 16.512 5.374 18.626 7.488 18.097z" />
                                    <path
                                        d="M4.03,15.758l-1,4c-0.086,0.341,0.015,0.701,0.263,0.949C3.482,20.896,3.738,21,4,21c0.081,0,0.162-0.01,0.242-0.03l4-1 c0.176-0.044,0.337-0.135,0.465-0.263l8.292-8.292l1.294,1.292l1.414-1.414l-1.294-1.292L21,7.414 c0.378-0.378,0.586-0.88,0.586-1.414S21.378,4.964,21,4.586L19.414,3c-0.756-0.756-2.072-0.756-2.828,0l-2.589,2.589l-1.298-1.296 l-1.414,1.414l1.298,1.296l-8.29,8.29C4.165,15.421,4.074,15.582,4.03,15.758z M5.903,16.512l8.095-8.095l1.586,1.584 l-8.096,8.096l-2.114,0.529L5.903,16.512z" />
                                </svg>
                            </button>

                            <div x-show="isBackgroundColorsOpen" @click.away="isBackgroundColorsOpen = false"
                                x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="w-[19rem] origin-top-right absolute right-[-190px] lg:top-[-110px] lg:right-[65px] mt-2 rounded-md shadow-lg">
                                <div class="rounded-md bg-white shadow-xs px-4 py-3">
                                    <div class="flex flex-wrap -mx-2">
                                        <template x-for="(color, index) in backgroundColors" :key="index">
                                            <div class="px-2">
                                                <template x-if="backgroundColorSelected === color">
                                                    <div class="w-8 h-8 inline-flex rounded-full cursor-pointer border-4 border-white"
                                                        :style="`background: ${color}; box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.2);`">
                                                    </div>
                                                </template>

                                                <template x-if="backgroundColorSelected != color">
                                                    <div @click="changeColor(color)"
                                                        @keydown.enter="backgroundColorSelected = color" role="checkbox"
                                                        tabindex="0" :aria-checked="backgroundColorSelected"
                                                        class="w-8 h-8 inline-flex rounded-full cursor-pointer border-4 border-white focus:outline-none focus:shadow-outline"
                                                        :style="`background: ${color};`"></div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full px-2 mt-4 ">
                        <label>
                            الوصف
                        </label>
                        <textarea id="description" placeholder="اكتب هنا المعلومات الاضافية الخاصة بالخدمة ..." wire:model="description"
                            rows="6" withError="description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                            shadow-sm bg-gray-100 resize mt-4 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <button class="mx-2 btn-dark text-sm " wire:click="createClinicServiceAction"
                    wire:loading.attr="disabled">
                    {{ __('حفظ') }}
                </button>
                <x-danger-button @click="{{ $showName }} = false" wire:loading.attr="disabled">
                    {{ __('اغلاق') }}
                </x-danger-button>
            </x-slot>
        </x-modals.modal>
    </div>
</div>

@push('scripts')
    <script>
        function addModal() {
            return {
                {{ $showName }}: false,
            }
        }

        function colorSelector() {
            return {
                isBackgroundColorsOpen: false,
                backgroundColors: [
                    '#2196F3', '#009688', '#9C27B0', '#FFEB3B', '#afbbc9',
                    '#4CAF50', '#2d3748', '#f56565', '#ed64a6', '#ff5722',
                    '#607d8b', '#673AB7', '#3f51b5', '#00BCD4', '#1a202c',
                    '#5A67D8', '#E53E3E', '#38A169',
                ],
                backgroundColorSelected: '#9C27B0',
                changeColor(color) {
                    this.backgroundColorSelected = color;
                    if (this.$refs.colorButton) {
                        this.$refs.colorButton.style.backgroundColor = color;
                    }
                    if (this.$refs.colorInput) {
                        this.$refs.colorInput.value = color;
                        this.$refs.colorInput.dispatchEvent(new Event('input', {
                            bubbles: true
                        })); // Notify Livewire
                    }
                },
            }
        }
    </script>
@endpush
