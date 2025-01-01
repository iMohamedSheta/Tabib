<div>
    @if ($withButton)
        <button class="btn-primary  mx-2" @click="{{ $showName }} = true">
            <i class="fa-solid fa-pen-to-square px-1"></i>
            اضافة مريض
        </button>
    @endif
    <div>
        <x-modals.modal @keydown.escape.window="{{ $showName }} = false" show="{{ $showName }}" maxWidth="6xl">
            <x-slot name="title">
                اضافة مريض
            </x-slot>

            <x-slot name="content">

                <h3 class="pb-2">
                    من فضلك ادخل بيانات المريض
                </h3>
                {{-- <div class="w-2/12 pl-4">
                        <div class="bg-c-gray-800 w-full h-full rounded-lg overflow-hidden">
                            <nav class="flex min-w-[240px] flex-col gap-1 py-1.5">
                                <div role="button"
                                    class="text-gray-200 flex w-full items-center p-3 transition-all hover:bg-c-gray-600 focus:bg-c-gray-600 active:bg-c-gray-600">
                                    <i class="fa-solid fa-pen-to-square px-1"></i>
                                    <span class="mx-2">البيانات الشخصية</span>
                                </div>
                                <div role="button"
                                    class="text-gray-200 flex w-full items-center p-3 transition-all hover:bg-c-gray-600 focus:bg-c-gray-600 active:bg-c-gray-600">
                                    <i class="fa-solid fa-medkit px-1"></i>
                                    <span class="mx-2">البيانات الطبية</span>
                                </div>
                                <div role="button"
                                    class="text-gray-200 flex w-full items-center p-3 transition-all hover:bg-c-gray-600 focus:bg-c-gray-600 active:bg-c-gray-600">
                                    <i class="fa-solid fa-wallet px-1"></i>
                                    <span class="mx-2">البيانات المالية</span>
                                </div>
                            </nav>
                        </div>
                    </div> --}}

                <div x-data="{ selectedTab: 'groups' }" class="w-full">
                    <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()"
                        class="flex gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700"
                        role="tablist" aria-label="tab options">
                        <button @click="selectedTab = 'groups'" :aria-selected="selectedTab === 'groups'"
                            :tabindex="selectedTab === 'groups' ? '0' : '-1'"
                            :class="selectedTab === 'groups' ?
                                'font-bold text-black border-b-2 border-black dark:border-white' :
                                'text-neutral-600 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelGroups">
                            <i class="fa fa-address-card"></i>
                            البيانات الشخصية
                            @if ($errors->any())
                                <i class="fa fa-triangle-exclamation fa-xl text-red-500 "></i>
                            @endif
                        </button>
                        <button @click="selectedTab = 'health'" :aria-selected="selectedTab === 'health'"
                            :tabindex="selectedTab === 'health' ? '0' : '-1'"
                            :class="selectedTab === 'health' ?
                                'font-bold text-black border-b-2 border-black dark:border-white' :
                                'text-neutral-600 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelHealth">
                            <i class="fa fa-medkit"></i>
                            البيانات الصحية
                        </button>
                        <button @click="selectedTab = 'additional'" :aria-selected="selectedTab === 'additional'"
                            :tabindex="selectedTab === 'additional' ? '0' : '-1'"
                            :class="selectedTab === 'additional' ?
                                'font-bold text-black border-b-2 border-black dark:border-white' :
                                'text-neutral-600 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelAdditional">
                            <i class="fa fa-medkit"></i>
                            البيانات الاضافية
                        </button>
                    </div>
                    {{--
                    <h3 class="pb-2">
                        من فضلك ادخل بيانات الطبيب
                    </h3> --}}
                    <div x-show="selectedTab === 'groups'" id="tabpanelGroups" role="tabpanel" aria-label="groups">
                        <div class="flex flex-wrap">
                            <div class="mt-4 w-full md:w-1/3 px-2">
                                <label>
                                    الاسم الاول
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="first_name" wire:model="first_name" withError="first_name"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full md:w-1/3 px-2">
                                <label>
                                    اسم العائلة
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="last_name" wire:model="last_name" withError="last_name"
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
                                <x-input type="text" id="other_phone" wire:model="other_phone"
                                    withError="other_phone"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    العيادة
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-select.select label="اختيار العيادة" withError="clinic_id" :items="$clinics"
                                    wire:model="clinic_id"
                                    class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                                </x-select.select>
                            </div>
                            <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    الجنس
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-select.select label="اختيار النوع" withError="gender" :items="['male' => 'ذكر', 'female' => 'انثى']"
                                    wire:model="gender"
                                    class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                                </x-select.select>
                            </div>
                            <div class="mt-4 w-full  px-2">
                                <label>
                                    العنوان
                                </label>
                                <textarea id="address" placeholder="اكتب هنا عنوان المريض..." wire:model="address" rows="4"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                    shadow-sm bg-gray-100 resize mt-4 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                    <div x-show="selectedTab === 'health'" id="tabpanelHealth" role="tabpanel"
                        aria-label="health_inforamtion">
                        <div class="flex flex-wrap">
                            <div class="mt-4 w-full md:w-1/2 px-2">
                                <label>
                                    الطول *cm
                                </label>
                                <x-input type="number" id="height" wire:model="height" min="0"
                                    withError="height"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full md:w-1/2 px-2">
                                <label>
                                    الوزن *kg
                                </label>
                                <x-input type="number" id="weight" wire:model="weight" min="0"
                                    withError="weight"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full  px-2">
                                <label>
                                    الحساسية
                                </label>
                                <textarea id="allergies" placeholder="اكتب هنا المعلومات الخاصة بالحساسية لدي المريض ..." wire:model="allergies"
                                    rows="4"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                shadow-sm bg-gray-100 resize mt-4 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>

                            </div>
                        </div>
                    </div>
                    <div x-show="selectedTab === 'additional'" id="tabpanelAdditional" role="tabpanel">
                        <div class="flex flex-wrap">
                            <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    الجنسية
                                </label>
                                <x-select.select label="اختيار النوع" withError="nationality" :items="['مصر', 'فرنسا']"
                                    wire:model="gender"
                                    class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                                </x-select.select>
                            </div>

                            <div class="w-full  px-2 mt-4 md:w-1/2">
                                <label>
                                    الرقم القومي
                                </label>
                                <x-input type="text" id="national_card_id" wire:model="national_card_id"
                                    withError="national_card_id"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>


                            <div class="w-full px-2 mt-4 ">
                                <label>
                                    مذكرة المريض (notes)
                                </label>
                                <textarea id="notes" placeholder="اكتب هنا المعلومات الاضافية الخاصة بالمريض ..." wire:model="notes"
                                    rows="6" withError="notes"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                    shadow-sm bg-gray-100 resize mt-4 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
                            </div>
                            <x-fileupload.profile-picture x-on:added.window="imagePreview = null" withError="photo"
                                wire:model="photo"></x-fileupload.profile-picture>
                        </div>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <button class="mx-2 btn-dark text-sm " wire:click="addPatientAction" wire:loading.attr="disabled">
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
    </script>
@endpush
