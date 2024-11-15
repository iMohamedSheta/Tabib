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
                <div class="flex flex-wrap">
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            الاسم الاول
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="text" id="first_name" wire:model="first_name" withError="first_name"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            اسم العائلة
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="text" id="last_name" wire:model="last_name" withError="last_name"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            السن
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="number" id="age" wire:model="age" withError="age"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
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
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            رقم الهاتف
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input type="text" id="phone" wire:model="phone" withError="phone"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            رقم الهاتف الاضافي
                        </label>
                        <x-input type="text" id="other_phone" wire:model="other_phone" withError="other_phone"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-6 w-full md:w-1/3 px-2">
                        <label>
                            الجنس
                            <span class="text-red-600">*</span>
                        </label>
                        <x-select.select label="اختيار النوع" withError="gender" :items="['male' => 'ذكر','female' => 'انثى']" wire:model="gender"
                            class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                        </x-select.select>
                    </div>
                    <div class="mt-6 w-full md:w-1/3 px-2">
                        <label>
                            الجنسية
                        </label>
                        <x-select.select label="اختيار النوع" withError="nationality" :items="['مصر', 'فرنسا']" wire:model="gender"
                            class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                        </x-select.select>
                    </div>
                    <div class="mt-4 w-full md:w-1/3 px-2">
                        <label>
                            العنوان
                        </label>
                        <x-input type="text" id="address" wire:model="address"
                            withError="address"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/4 px-2">
                        <label>
                            الحساسية
                        </label>
                        <x-input type="text" id="allergies" wire:model="allergies"
                            withError="allergies"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/4 px-2">
                        <label>
                            الطول *cm
                        </label>
                        <x-input type="number" id="height" wire:model="height" min="0" withError="height"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                            spellcheck="false" />
                    </div>
                    <div class="mt-4 w-full md:w-1/4 px-2">
                        <label>
                            الوزن *kg
                        </label>
                        <x-input type="number" id="weight" wire:model="weight" min="0" withError="weight"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                            spellcheck="false" />
                    </div>
                    <div class="w-full  px-2 mt-4 md:w-1/4">
                        <label>
                            الرقم القومي
                        </label>
                        <x-input type="text" id="national_card_id" wire:model="national_card_id" withError="national_card_id"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                            spellcheck="false" />
                    </div>
                    <div class="w-full px-2 mt-4 ">
                        <label>
                            مذكرة المريض (notes)
                        </label>
                        <textarea id="notes" placeholder="اكتب هنا المعلومات الاضافية الخاصة بالمريض ..." wire:model="notes" rows="6" withError="notes" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                            shadow-sm bg-gray-100 resize mt-4 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                            spellcheck="false"></textarea>
                    </div>
                    <x-fileupload.profile-picture x-on:added.window="imagePreview = null" withError="photo"
                        wire:model="photo"></x-fileupload.profile-picture>
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
