@php
    use App\Enums\Clinic\ClinicTypeEnum;
@endphp
<div>
    <div x-on:updated-event.window="showUpdate = false">
        <x-modals.modal @keydown.escape.window="showUpdate = false" show="showUpdate" maxWidth="2xl">
            <x-slot name="title">
                تعديل الحجز
            </x-slot>

            <x-slot name="content">
                <h3 class="pb-2">
                    من فضلك ادخل بيانات الحجز
                </h3>

                <div class="flex flex-wrap">
                    <div class="w-full  px-2 mt-4 ">
                        <label>
                            عنوان الحجز
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="text" id="update_title" x-model="update_title" wire:ignore withError="title"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                            autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="w-full  px-2 mt-4 ">
                        <label>
                            يبدا في
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="date" id="update-evert-start-datepicker" wire:ignore x-model="update_start"
                            withError="start"
                            class='border-gray-300  focus:border-indigo-500 mt-4 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm' />

                    </div>
                    <div class="w-full  px-2 mt-4 ">
                        <label>
                            ينتهي في
                        </label>
                        <x-input type="date" id="update-evert-end-datepicker" wire:ignore x-model="update_end"
                            withError="end" wire:model="update_end"
                            class='border-gray-300  focus:border-indigo-500 mt-4 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm' />

                    </div>
                    <div>
                        {{-- <input type="hidden" x-on:update-model.window="$wire.set('model', $event.detail)" /> --}}
                    </div>
                    <input type="hidden" id="update-event-id" x-model="update_event_id" wire:model="update_event_id" />


                    <div class="flex items-center" x-cloak>
                        <div>
                            <label for="backgroundColorSelected" class="block font-bold px-3 py-4 ">لون الخلفية</label>
                            <input id="backgroundColorSelected" type="text" placeholder="Pick a color"
                                class="border-gray-300  focus:border-indigo-500 mx-3 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm"
                                readonly x-model="backgroundColorSelected">
                        </div>
                        <div class="relative ml-3 mt-8">
                            <button type="button" @click="isBackgroundColorsOpen = !isBackgroundColorsOpen"
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
                                class="origin-top-right absolute top-[-110px] right-[65px] mt-2 w-40 rounded-md shadow-lg">
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
                                                    <div @click="backgroundColorSelected = color"
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
                </div>
            </x-slot>

            <x-slot name="footer">
                {{-- x-on:click="@this.call('updateEventAction') --}}
                {{-- <button type="button" x-on:click="updateEventAction()" wire:loading.attr="disabled"  class="mx-2 btn-dark text-sm">
                    <i class="fa fa-spinner fa-spin px-1" wire:loading wire:target="updateEventAction"></i>
                    {{ __('حفظ') }}
                </button> --}}
                <div class="flex justify-between items-center w-full">
                    <x-danger-button x-on:click="deleteEventAction()"
                        x-on:deleted:event.window="showUpdate = false; this.$refresh()" wire:loading.attr="disabled">
                        {{ __('حذف') }}
                    </x-danger-button>
                    <div>
                        <button type="button" x-on:click="isUpdateLoading = true; updateEventAction()"
                            x-bind:disabled="isUpdateLoading"
                            x-on:rendered-update-event-modal.window="isUpdateLoading = false"
                            class="mx-2 btn-dark text-sm disabled:opacity-50">
                            <i class="fa fa-spinner fa-spin px-1" x-show="isUpdateLoading"></i>
                            {{ __('حفظ') }}
                        </button>
                        <x-danger-button x-on:click="showUpdate = false">
                            {{ __('اغلاق') }}
                        </x-danger-button>
                    </div>
                </div>
            </x-slot>
        </x-modals.modal>
    </div>
</div>
