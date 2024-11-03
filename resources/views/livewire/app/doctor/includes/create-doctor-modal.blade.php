<div x-data="addModal" x-on:added="show = false" >
    <button class="btn-primary text-sm mx-2" @click="show = true">
        <i class="fa-solid fa-pen-to-square px-1"></i>
        اضافة طبيب
    </button>
    <div >
        <x-modals.modal @keydown.escape.window="show = false" maxWidth="4xl">
            <x-slot name="title">
                اضافة طبيب
            </x-slot>

            <x-slot name="content">
                <h3 class="pb-2">
                    من فضلك ادخل بيانات الطبيب
                </h3>
                <div class="flex flex-wrap">
                    <div class="w-full  px-2 mt-4 md:w-1/2">
                        <label>
                                اسم المستخدم
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input  type="text" id="username" wire:model="username" withError="username"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            />
                        </div>
                        <div class="w-full px-2 mt-4 md:w-1/2">
                            <label>
                                الرقم السري
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input  type="password" id="password" wire:model="password" withError="password"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            />
                        </div>
                        <div class="mt-4 w-full md:w-1/2 px-2">
                            <label>
                                التخصص
                                <span class="text-red-600">*</span>
                            </label>
                            <x-input  type="text" id="specialization" wire:model="specialization" withError="specialization"
                                class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                            />
                        </div>
                        <div class="mt-6 w-full md:w-1/2 px-2">
                            <label>
                                العيادة
                                <span class="text-red-600">*</span>
                            </label>
                            <x-select.select label="اختيار العيادة" withError="clinic_id"
                            :items="$clinics" :items="$clinics" wire:model="clinic_id"
                            class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                            </x-select.select>
                        </div>
                    <div class="mt-4 w-full md:w-1/2 px-2">
                        <label>
                            الاسم الاول
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input  type="text" id="first_name" wire:model="first_name" withError="first_name"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        />
                    </div>
                    <div class="mt-4 w-full md:w-1/2 px-2">
                        <label>
                            اسم العائلة
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input  type="text" id="last_name" wire:model="last_name" withError="last_name"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        />
                    </div>
                    <div class="mt-4 w-full md:w-1/2 px-2">
                        <label>
                            رقم الهاتف
                            <span class="text-red-600">*</span>
                        </label>
                        <x-input  type="text" id="phone" wire:model="phone" withError="phone"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        />
                    </div>
                    <div class="mt-4 w-full md:w-1/2 px-2">
                        <label>
                            رقم الهاتف الاضافي
                        </label>
                        <x-input  type="text" id="other_phone" wire:model="other_phone" withError="other_phone"
                            class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        />
                    </div>

                    <x-fileupload.profile-picture x-on:added.window="imagePreview = null" withError="photo"  wire:model="photo" ></x-fileupload.profile-picture>
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
        }
    }

</script>
@endpush
