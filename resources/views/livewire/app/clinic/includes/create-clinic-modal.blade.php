@php
    use App\Enums\Clinic\ClinicTypeEnum;
@endphp
<div x-data="addModal" x-on:added="show = false">
    <button class="btn-primary  mx-2" @click="show = true">
        <i class="fa-solid fa-pen-to-square px-1"></i>
        اضافة عيادة
    </button>
    <div>
        <x-modals.modal @keydown.escape.window="show = false" maxWidth="4xl">
            <x-slot name="title">
                اضافة عيادة
            </x-slot>

            <x-slot name="content">
                <h3 class="pb-2">
                    من فضلك ادخل بيانات العيادة
                </h3>
                <div class="flex flex-col overflow-y-auto md:flex-row">

                    <div class="flex items-center justify-center p-6 sm:p-12  bg-purple-600 shadow-lg">
                        <x-stepper.step-start title="اختيار خطة العيادة" :active="$this->isFirstStep() ? 1 : 0" :nextIsActive="$step == 2 ? 1 : 0"
                            :done="$step > 1">
                            @slot('icon')
                                <i class="fa-solid fa-bag-shopping fa-shake fa-xl px-1"></i>
                            @endslot
                            بيانات خاصة بالعيادة الخاصة بك
                        </x-stepper.step-start>

                        <x-stepper.step-middle title="بيانات العيادة" :active="$step == 2 ? 1 : 0" :nextIsActive="$this->isLastStep()"
                            :done="$step > 2">
                            @slot('icon')
                                <i class="fa-solid fa-suitcase-medical @if($step == 2 ? 1 : 0) fa-bounce @endif fa-xl px-1"></i>
                            @endslot
                            بيانات خاصة بالعيادة الخاصة بك
                        </x-stepper.step-middle>

                        <x-stepper.step-end title="تأكيد العيادة" :active="$this->isLastStep()" :done="$step > 3">
                            @slot('icon')
                                <i
                                    class="fa-solid fa-clipboard-check @if ($this->isLastStep()) fa-flip @endif fa-xl px-1"></i>
                            @endslot
                            بيانات خاصة بالمستخدم الخاص بك علي النظام
                        </x-stepper.step-end>
                    </div>
                    <div class="flex items-center bg-purple-200 md:rounded-l-xl rounded-b-xl  md:rounded-r-none justify-center p-6 md:w-2/3">
                        <div class="w-full ">
                            @if ($step == 1)
                            <div>
                                <div class="p-4 group  bg-white mb-4 shadow">
                                    <h3 class="text-lg flex  align-middle">
                                        <x-checkbox class="mx-2 mt-1 focus:ring-0 focusring-offset-0"></x-checkbox>
                                        الخطة العادية
                                    </h3>
                                    <p  class="w-full block">
                                        الخطة العادية هي خطة تسمحلك بانها تكون عادية بشكل مش عادي
                                    </p>
                                </div>
                                <div class="p-4 text-white mb-4 shadow bg-yellow-600">
                                    <h3 class="text-lg ">
                                        الخطة الذهبية
                                    </h3>
                                    <p class="text-purple-50 pt-1">
                                        الخطة العادية هي خطة تسمحلك بانها تكون عادية بشكل مش عادي
                                    </p>
                                </div>
                            </div>
                            @elseif ($step == 2)
                                <div class="w-full  px-2 mt-4 ">
                                    <label>
                                        اسم العيادة
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <x-input type="text" id="name" wire:model="name" withError="name"
                                        class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                                        autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                        spellcheck="false" />
                                </div>
                                <div class="mt-6 w-full  px-2">
                                    <label>
                                        نوع العيادة
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <x-select.select label="اختيار العيادة" withError="type" :items="ClinicTypeEnum::getClinicTypeLabels()"
                                        wire:model="type"
                                        class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
                                    </x-select.select>
                                </div>
                                <div class="w-full px-2 mt-4 md:w-2/2">
                                    <label>
                                        المكان
                                    </label>
                                    <x-input type="text" id="location" wire:model="location" withError="location"
                                        class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all "
                                        autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
                                        spellcheck="false" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                @if ($step == 2)
                    <button class="mx-2 btn-dark text-sm " wire:click="addClinicAction" wire:loading.attr="disabled">
                        {{ __('حفظ') }}
                    </button>
                @elseif ($step == 1)
                    <button class="mx-2 btn-dark text-sm " wire:click="nextStep" wire:loading.attr="disabled">
                        {{ __('التالي') }}
                    </button>
                @endif
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
