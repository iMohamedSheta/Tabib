<div x-data="addModal" x-on:added="show = false">
    <button class="btn-primary  mx-2" @click="show = true">
        <i class="fa-solid fa-pen-to-square px-1"></i>
        اضافة طبيب
    </button>
    <div>
        <x-modals.modal @keydown.escape.window="show = false" maxWidth="4xl" class="bg-c-gray-800 opacity-95">
            {{-- <x-slot name="title">
                اضافة طبيب
            </x-slot> --}}

            <x-slot name="content">
                <div x-data="{ selectedTab: 'groups', start_time: '', end_time: '' }" class="w-full">
                    <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()"
                        class="flex gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700"
                        role="tablist" aria-label="tab options">
                        <button @click="selectedTab = 'groups'" :aria-selected="selectedTab === 'groups'"
                            :tabindex="selectedTab === 'groups' ? '0' : '-1'"
                            :class="selectedTab === 'groups' ?
                                'font-bold text-gray-300 border-b-2 border-black dark:border-white' :
                                'text-gray-400 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelGroups">
                            <i class="fa fa-address-card"></i>
                            البيانات الشخصية
                            @if ($errors->any())
                                <i class="fa fa-triangle-exclamation fa-xl text-red-500 "></i>
                            @endif
                        </button>
                        <button @click="selectedTab = 'work'" :aria-selected="selectedTab === 'work'"
                            :tabindex="selectedTab === 'work' ? '0' : '-1'"
                            :class="selectedTab === 'work' ?
                                'font-bold text-gray-300 border-b-2 border-black dark:border-white' :
                                'text-gray-400 font-medium  dark:hover:border-b-neutral-300  hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
                            class="flex h-min items-center gap-2 px-4 py-2 text-sm" type="button" role="tab"
                            aria-controls="tabpanelWork">
                            <i class="fa fa-address-book"></i>
                            البيانات الاضافية
                        </button>
                    </div>
                    {{--
                <h3 class="pb-2">
                    من فضلك ادخل بيانات الطبيب
                </h3> --}}
                    <div x-show="selectedTab === 'groups'" id="tabpanelGroups" role="tabpanel" aria-label="groups">
                        <div class="flex flex-wrap p-4">
                            <div class="w-full text-gray-300 px-2 mt-4 md:w-1/2">
                                <label>
                                    اسم المستخدم
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="username" wire:model="username" withError="username"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="w-full text-gray-300 px-2 mt-4 md:w-1/2">
                                <label>
                                    الرقم السري
                                    <span class="text-red-600">*</span>
                                </label>
                                {{-- <x-input type="password" id="password" wire:model="password" withError="password"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" /> --}}
                                <x-form.input-password type="password" id="password" wire:model="password"
                                    withError="password"
                                    class="bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" label="الرقم السري"></x-form.input-password>

                            </div>
                            <div class="mt-4 text-gray-300 w-full px-2">
                                <label>
                                    التخصص
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="specialization" wire:model="specialization"
                                    withError="specialization"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            {{-- <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    العيادة
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-select.select label="اختيار العيادة" withError="clinic_id"
                                :items="$clinics" wire:model="clinic_id"
                                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                                </x-select.select>
                            </div> --}}
                            <div class="mt-4 text-gray-300 w-full md:w-1/2 px-2">
                                <label>
                                    الاسم الاول
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="first_name" wire:model="first_name" withError="first_name"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full text-gray-300 md:w-1/2 px-2">
                                <label>
                                    اسم العائلة
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="last_name" wire:model="last_name" withError="last_name"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full text-gray-300 md:w-1/2 px-2">
                                <label>
                                    رقم الهاتف
                                    <span class="text-red-600">*</span>
                                </label>
                                <x-input type="text" id="phone" wire:model="phone" withError="phone"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 text-gray-300 w-full md:w-1/2 px-2">
                                <label>
                                    رقم الهاتف الاضافي
                                </label>
                                <x-input type="text" id="other_phone" wire:model="other_phone"
                                    withError="other_phone"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>

                            <x-fileupload.profile-picture x-on:added.window="imagePreview = null" withError="photo"
                                wire:model="photo"></x-fileupload.profile-picture>
                        </div>
                    </div>
                    <div x-show="selectedTab === 'work'" id="tabpanelWork" role="tabpanel"
                        aria-label="work_inforamtion">
                        <div class="flex flex-wrap p-4  text-gray-300">
                            <div class="w-full  px-2 mt-4 md:w-1/2">
                                <label>
                                    رقم الترخيص
                                </label>
                                <x-input type="text" id="license_number" wire:model="license_number"
                                    withError="license_number"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-4 w-full px-2 md:w-1/2">
                                <label>
                                    رقم الهاتف للاستشارات الطبية
                                </label>
                                <x-input type="text" id="telehealth_phone" wire:model="telehealth_phone"
                                    withError="telehealth_phone"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" />
                            </div>
                            <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    العيادات
                                </label>
                                <x-select.multiselect :items="$clinics" label="اختيار العيادات" withError="clinic_ids"
                                    class="mt-2 bg-c-gray-700 px-4 py-2 rounded-sm text-xs text-gray-300 w-full break-all">

                                </x-select.multiselect>
                            </div>
                            <div class="mt-6 w-full md:w-1/2 px-2">
                                <label>
                                    ايام العمل
                                </label>
                                <x-select.multiselect :items="$days" label="اختيار ايام العمل"
                                    withError="selected_days"
                                    class="mt-2 bg-c-gray-700 px-4 py-2 rounded-sm text-xs text-gray-300 w-full break-all">

                                </x-select.multiselect>
                            </div>
                            <div class="w-full  px-2 mt-4 md:w-1/2">
                                <label>
                                    توقيت العمل بداية من
                                </label>
                                <x-input type="date" id="start-time-datepicker" wire:ignore x-model="start_time"
                                    withError="start_time" wire:model="start_time"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all" />
                            </div>
                            <div class="w-full  px-2 mt-4 md:w-1/2">
                                <label>
                                    توقيت العمل نهاية في
                                </label>
                                <x-input type="date" id="end-time-datepicker" wire:ignore x-model="end_time"
                                    withError="end_time" wire:model="end_time"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-sm text-gray-300 w-full break-all" />
                            </div>
                            <div class="w-full  px-2 mt-4">
                                <label>
                                    المؤهلات
                                </label>
                                <textarea id="qualifications" placeholder="اكتب المؤهلات الخاصة بالطبيب..." wire:model="qualifications"
                                    rows="3" withError="qualifications"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-xs text-gray-300 w-full break-all" autofocus
                                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>

                                {{-- <x-input type="text" id="qualifications" wire:model="qualifications"
                                    withError="qualifications"
                                    class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                    spellcheck="false" /> --}}
                            </div>
                            <div class="w-full px-2 mt-4">
                                <label>
                                    مذكرة الدكتور (notes)
                                </label>
                                <textarea id="notes" placeholder="اكتب هنا المعلومات الاضافية الخاصة بالمريض ..." wire:model="notes"
                                    rows="6" withError="notes"
                                    class="mt-4 bg-c-gray-700 px-4 border-0 py-2 rounded-sm text-xs text-gray-300 w-full break-all" autofocus
                                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <button class="mx-2 btn-dark text-sm " wire:click="addDoctorAction" wire:loading.attr="disabled">
                    {{ __('حفظ') }}
                </button>
                <x-danger-button @click="show = false" wire:loading.attr="disabled">
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
                show: false,
                init() {
                    this.flatpickerupdateStartInstance = this.createFlatpickr('#start-time-datepicker');
                    this.flatpickerupdateEndInstance = this.createFlatpickr('#end-time-datepicker');
                },
                createFlatpickr(key) {
                    return flatpickr(key, {
                        locale: 'ar',
                        noCalendar: true,
                        enableTime: true,
                        dateFormat: 'h:i K',
                        onOpen: () => {
                            let flatpickrCalendars = document.querySelectorAll('.flatpickr-calendar');
                            let calendarComponent = document.getElementById('calendarComponent');
                            if (flatpickrCalendars && calendarComponent) {
                                flatpickrCalendars.forEach(flatpickrCalendar => {
                                    calendarComponent.appendChild(flatpickrCalendar);
                                });
                            }
                        }
                    });
                }
            }
        }
    </script>
@endpush
