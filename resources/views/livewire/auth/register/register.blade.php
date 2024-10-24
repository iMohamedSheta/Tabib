<div>
    <div>

        <div class="flex flex-col overflow-y-auto md:flex-row shadow-lg">
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 bg-purple-600 shadow-lg">
                <x-stepper.step-start title="بيانات العيادة" :active="$this->isFirstStep() ? 1 : 0" :nextIsActive="$step == 2 ? 1 : 0" :done="$step > 1">
                    @slot('icon')
                        <i class="fa-solid fa-suitcase-medical fa-bounce fa-xl px-1"></i>
                    @endslot
                    بيانات خاصة بالعيادة الخاصة بك
                </x-stepper.step-start>

                <x-stepper.step-middle title="البيانات الشخصية" :active="$step == 2 ? 1 : 0" :nextIsActive="$this->isLastStep()" :done="$step > 2">
                    @slot('icon')
                        <i class="fa-solid fa-circle-user @if($step == 2) fa-shake @endif fa-xl px-1"></i>
                    @endslot
                    بيانات شخصية عنك مثل التلفون واسمك
                </x-stepper.step-middle>

                <x-stepper.step-end title="بيانات المستخدم" :active="$this->isLastStep()" :done="$step > 3">
                    @slot('icon')
                        <i class="fa-solid fa-id-card @if($this->isLastStep()) fa-flip @endif fa-xl px-1"></i>
                    @endslot
                    بيانات خاصة بالمستخدم الخاص بك علي النظام
                </x-stepper.step-end>
            </div>
            @if ($step == 1)
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

                        <x-form.button type="button" wire:click="submitStepOne" wire:loading.attr="disabled">
                            أنشاء العيادة
                        </x-form.button>


                        <hr class="my-8" />
                        <x-form.link href="{{ route('socialite.google.redirect') }}">
                            <i class="fa-brands fa-google"></i>
                            <span class="px-2">
                                التسجيل عن طريق بريد جوجل
                            </span>
                        </x-form.link>

                        <x-form.link href="{{ route('socialite.facebook.redirect') }}" class="mt-4">
                            <i class="fa-brands fa-facebook"></i>
                            <span class="px-2">
                                التسجيل عن طريق الفيس بوك
                            </span>
                        </x-form.link>

                    </div>
                </div>
            @elseif ($step == 2)
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h4 class="text-lg text-white mb-8">
                            البيانات الشخصية
                        </h4>
                        <x-form.input-text id="first_name" label="الاسم الاول" withError="first_name"
                            wire:model="first_name">
                        </x-form.input-text>

                        <x-form.input-text id="last_name" label="اسم العائلة" withError="last_name"
                            wire:model="last_name">
                        </x-form.input-text>

                        <x-form.input-text id="phone" type="tel"  label="رقم الهاتف" withError="phone"
                            wire:model="phone">
                        </x-form.input-text>

                        <x-form.button type="button" class="mt-6" wire:click="submitStepTwo"
                            wire:loading.attr="disabled">
                            المتابعة
                        </x-form.button>
                    </div>
                </div>
            @elseif ($step == 3)
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">

                        <x-form.input-text id="username" label="اسم المستخدم"
                            placeholder='اسم المستخدم مثل mohamedsheta' withError="username" wire:model="username">
                        </x-form.input-text>

                        <x-form.input-text type="password" label="الرقم السري" placeholder='**********'
                            withError="password" wire:model="password">
                        </x-form.input-text>

                        <x-form.input-text type="password" label="تأكيد الرقم السري" placeholder='**********'
                            withError="password_confirmation" wire:model="password_confirmation">
                        </x-form.input-text>

                        <x-form.button type="button" class="mt-6" wire:click="submitStepThree"
                            wire:loading.attr="disabled">
                            تأكيد أنشاء العيادة
                        </x-form.button>
                    </div>
                </div>
            @endif

        </div>
    </div>


</div>
