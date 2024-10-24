<div>
    <div class="flex flex-col overflow-y-auto md:flex-row shadow-lg">
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 bg-purple-600 shadow-lg">
            <x-stepper.step-start title="بيانات العيادة" :active="1" nextIsActive="0" :done="0">
                @slot('icon')
                    <i class="fa-solid fa-suitcase-medical fa-bounce fa-xl px-1"></i>
                @endslot
                بيانات خاصة بالعيادة الخاصة بك
            </x-stepper.step-start>

            <x-stepper.step-middle title="البيانات الشخصية" active="0" nextIsActive="0" :done="1">
                @slot('icon')
                    <i class="fa-solid fa-circle-user  fa-xl px-1"></i>
                @endslot
                بيانات شخصية عنك مثل التلفون واسمك
            </x-stepper.step-middle>

            <x-stepper.step-end title="بيانات المستخدم" active="0" :done="1">
                @slot('icon')
                    <i class="fa-solid fa-id-card  fa-xl px-1"></i>
                @endslot
                بيانات خاصة بالمستخدم الخاص بك علي النظام
            </x-stepper.step-end>
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">

                <x-form.input-text x-data x-init="$el.focus()" id="name" label="انشاء العيادة" autocomplete="off"
                    labelClass="text-lg" placeholder='اسم العيادة مثل : عيادة وادي النيل' withError="name"
                    wire:model="name">
                </x-form.input-text>

                <x-form.select label="اختيار نوع العيادة" withError="type" :items="App\Enums\Clinic\ClinicTypeEnum::getClinicTypeLabels()" wire:model="type">
                </x-form.select>

                <x-form.checkbox wire:model="policy" withError="policy">
                    <h6 class="ml-2 px-2">
                        انا موافق علي
                        <span class="underline">سياسات الاستخدام</span>
                    </h6>
                </x-form.checkbox>

                <x-form.button type="button" class="mt-6" wire:click="createClinicAction"
                    wire:loading.attr="disabled">
                    تأكيد أنشاء العيادة
                </x-form.button>
            </div>
        </div>
    </div>
</div>
