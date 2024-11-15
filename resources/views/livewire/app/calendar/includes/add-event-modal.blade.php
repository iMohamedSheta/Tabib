@php
    use App\Enums\Clinic\ClinicTypeEnum;
@endphp
<div>
    <div  x-on:added="show = false">
        <x-modals.modal @keydown.escape.window="show = false" maxWidth="3xl">
            <x-slot name="title">
                <div x-show="step == 1">
                    اختر الطريقة المناسبة
                </div>
                <div x-show="step == 2">
                    اضافة مريض جديد
                </div>
                <div x-show="step == 3">
                    اختيار مريض مسجل
                </div>
            </x-slot>

            <x-slot name="content">
                <div x-show="step == 1" x-transition:enter>
                    <h3 class="pb-3">
                        اختر الطريقة المناسبة
                    </h3>
                    <div class="flex flex-wrap">
                        <div class="w-full md:max-w-[95%]  space-y-4 mx-auto">
                            <div x-on:click="step = 3"
                                class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-2xl overflow-hidden cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105">
                                <div class="p-6 flex items-center space-x-4">
                                    <!-- Icon placeholder -->
                                    <div class="h-12 w-12 text-green-500"></div>
                                    <i class="fas fa-user-circle text-5xl text-purple-100"></i>
                                    <div>
                                        <h2 class="text-xl font-semibold "> اختيار مريض مسجل</h2>
                                        <p class="text-purple-100 p-2">اختر المريض من قائمة المرضى</p>
                                    </div>
                                </div>
                                <div
                                    class="bg-gradient-to-r from-transparent via-green-200 to-transparent h-1 w-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out">
                                </div>
                            </div>

                            <!-- New Patient Card -->
                            <div x-on:click="step = 2"
                                class="bg-c-gray-600 hover:bg-c-gray-800 text-white rounded-lg shadow-2xl  overflow-hidden cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105">
                                <div class="p-6 flex items-center space-x-4">
                                    <!-- Icon placeholder -->
                                    <div class="h-12 w-12 text-green-500"></div>
                                    <i class="fas fa-user-plus text-4xl text-green-500"></i>
                                    <div>
                                        <h2 class="text-xl font-semibold ">اضافة مريض جديد</h2>
                                        <p class="text-purple-100 p-2">اضافة مريض جديد للنظام</p>
                                    </div>
                                </div>
                                <div
                                    class="bg-gradient-to-r from-transparent via-green-200 to-transparent h-1 w-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-transition:enter x-show="step == 2">
                    <h3 class="pb-2">
                        من فضلك ادخل بيانات المريض
                    </h3>
                    <div class="flex flex-wrap">
                        <div class="mt-4 w-full md:w-1/2 px-2">
                            <label>
                                الاسم الاول
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="text" id="first_name" wire:model="first_name" withError="first_name"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="mt-4 w-full md:w-1/2 px-2">
                            <label>
                                اسم العائلة
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="text" id="last_name" wire:model="last_name" withError="last_name"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="mt-4 w-full md:w-1/2 px-2">
                            <label>
                                رقم الهاتف
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="text" id="phone" wire:model="phone" withError="phone"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="mt-4 w-full md:w-1/2 px-2">
                            <label>
                                رقم الهاتف الاضافي
                            </label>
                            <x-input type="text" id="other_phone" wire:model="other_phone" withError="other_phone"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="mt-4 w-full md:w-1/3 px-2">
                            <label>
                                السن
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="number" id="age" wire:model="age" withError="age"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="mt-6 w-full md:w-1/3 px-2">
                            <label>
                                العيادة
                                <span class="text-red-600">*</span>
                            </label>
                            <x-select.select label="اختيار العيادة" withError="clinic_id" :items="$clinics"
                                wire:model="clinic_id"
                                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                            </x-select.select>
                        </div>
                        <div class="mt-6 w-full md:w-1/3 px-2">
                            <label>
                                الجنس
                                <span class="text-red-600">*</span>
                            </label>
                            <x-select.select label="اختيار النوع" withError="gender" :items="['male' => 'ذكر', 'female' => 'انثى']"
                                wire:model="gender"
                                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                            </x-select.select>
                        </div>

                        <div class="w-full  px-2 mt-4 hidden">
                            <label>
                                عنوان المهمة
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="text" id="title" wire:model="title" withError="title"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                        </div>
                        <div class="w-full  px-2 mt-4  hidden">
                            <label>
                                التاريخ
                                <span class="text-red-600">*</span>
                            </label>
                            <input type="date" id="datepicker" wire:ignore x-model="start" wire:model="start"
                                class='border-gray-300  focus:border-indigo-500 mt-4 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm' />

                        </div>

                        <div>
                            <input type="hidden" x-on:update-all-day.window="$wire.set('allDay', $event.detail)" />
                        </div>
                    </div>
                </div>

                <div x-transition:enter x-show="step == 3">
                    <h3 class="pb-2">
                        اختيار مريض مسجل
                    </h3>
                    <div class="flex flex-wrap">
                        <div class="mt-4 w-full px-2">
                            <label>
                                الاسم
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input type="text" id="patient" wire:model.live.debounce.500ms="search" withError="search"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                spellcheck="false" />
                            <ul class="bg-[#111827] rounded-b-2xl">
                                @foreach ($searchResults as $user)
                                    <li class="relative w-full ">
                                        <button class="flex justify-center items-center  px-4 py-2 text-white  hover:bg-[#1F2937] rounded-b-2xl focus:outline-none  transition-colors  ease-in-out duration-50 w-full" x-on:click="selectPatient('{{ $user->id }}')">
                                            <img class="object-cover w-8 h-8 rounded-full" src="{{ $this->getUserProfilePhotoUrl($user->profile_photo_path, $user->username, $user->first_name) }}"
                                            alt="" aria-hidden="true" />
                                            <span class="mr-2" aria-hidden="true">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-danger-button x-show="step == 1" x-on:click="show = false;setTimeout(() => step = 1, 300)">
                    {{ __('اغلاق') }}
                </x-danger-button>

                <div class="w-full" x-show="step == 2 || step == 3">

                    <div class="flex justify-between w-full">
                        <div>
                            <button class="btn-primary text-sm disabled:opacity-50"
                                x-on:click="step = 1">
                                <i class="fa fa-arrow-right px-1"></i>
                                {{ __('رجوع') }}
                            </button>
                        </div>
                        <div>
                            <button class="mx-2 btn-dark text-sm disabled:opacity-50"
                                x-on:keydown.enter.window="@this.addEventAction" wire:click="addEventAction"
                                wire:loading.attr="disabled">
                                <i class="fa fa-spinner fa-spin px-1" wire:loading wire:target="addEventAction"></i>
                                {{ __('حفظ') }}
                            </button>
                            <x-danger-button x-on:click="show = false;setTimeout(() => step = 1, 300)">
                                {{ __('اغلاق') }}
                            </x-danger-button>
                        </div>
                    </div>
                </div>
            </x-slot>
    </x-modals.modal>
</div>
</div>
