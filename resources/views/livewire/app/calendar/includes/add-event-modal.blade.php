<div>
    <div x-on:added.window="show = false;setTimeout(() => step = 1, 300)" x-on:added-event.window="step = 4">
        <x-modals.modal @keydown.escape.window="show = false" maxWidth="3xl">
            <x-slot name="title">
                <div x-show="step == 1">
                    اختر طريقة الحجز المناسبة
                </div>
                <div x-show="step == 2">
                    اضافة مريض جديد
                </div>
                <div x-show="step == 3">
                    اختيار مريض مسجل
                </div>
                <div x-show="step == 4">
                    تأكيد الفاتورة
                </div>
            </x-slot>

            <x-slot name="content">
                <div>
                    {{-- Blade file - Choose way to add event patient reservation --}}
                    @include('livewire.app.calendar.includes.add_event_includes.step1')
                    {{-- /Blade file --}}

                    {{-- Blade file -  Add new patient and select the patient reservation --}}
                    @include('livewire.app.calendar.includes.add_event_includes.step2')
                    {{-- /Blade file --}}

                    {{-- Blade file - Select existing patient and select the patient reservation --}}
                    @include('livewire.app.calendar.includes.add_event_includes.step3')
                    {{-- /Blade file --}}

                    {{-- Blade file - Invoice Receipt confirmation --}}
                    @include('livewire.app.calendar.includes.add_event_includes.step4')
                    {{-- /Blade file --}}
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-danger-button x-show="step == 1" x-on:click="show = false;setTimeout(() => step = 1, 300)">
                    {{ __('اغلاق') }}
                </x-danger-button>

                <div class="w-full" x-show="step == 2 || step == 3 || step == 4">

                    <div class="flex justify-between w-full">
                        <div>
                            <button class="btn-primary text-sm disabled:opacity-50" x-on:click="step = 1"
                                x-show="step != 4">
                                <i class="fa fa-arrow-right px-1"></i>
                                {{ __('رجوع') }}
                            </button>
                        </div>
                        <div>
                            <button class="mx-2 btn-dark text-sm disabled:opacity-50" x-show="step == 2"
                                wire:click="addPatientWithEventAction" wire:loading.attr="disabled">
                                <i class="fa fa-spinner fa-spin px-1" wire:loading
                                    wire:target="addPatientWithEventAction"></i>
                                {{ __('حفظ') }}
                            </button>
                            <button class="mx-2 btn-dark text-sm disabled:opacity-50" x-show="step == 3"
                                wire:click="addEventWithExistingPatientAction" wire:loading.attr="disabled">
                                <i class="fa fa-spinner fa-spin px-1" wire:loading
                                    wire:target="addEventWithExistingPatientAction"></i>
                                {{ __('حفظ') }}
                            </button>
                            <button class="mx-2 btn-dark text-sm disabled:opacity-50" x-show="step == 4"
                                wire:click="confirmInvoiceReceiptAction" wire:loading.attr="disabled">
                                <i class="fa fa-spinner fa-spin px-1" wire:loading
                                    wire:target="confirmInvoiceReceiptAction"></i>
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
