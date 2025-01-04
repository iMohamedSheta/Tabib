@php
    use App\Enums\Clinic\ClinicTypeEnum;
    use App\Enums\User\UserInfoEnum;
@endphp
<div>
    <x-modals.modal @keydown.escape.window="{{ $show }} = false" show="{{ $show }}" maxWidth="4xl">
        <x-slot name="title">
            بيانات الخدمات الطبية العامة
        </x-slot>

        <x-slot name="content">

            <h3 class="pb-2">
                البحث فى الخدمات الطبية العامة للبحث عن مريض او موعد او طبيب...الخ.
            </h3>
            <div class="flex flex-wrap">

                <div class="w-full">
                    <x-input wire:model.live.debounce.500ms="search" type="text" class="w-full bg-gray-100"
                        placeholder="ادخل اسم الخدمة الطبية" />
                </div>

                <div class="w-full">


                    <ul class="bg-[#111827] rounded-b-2xl">
                        @foreach ($searchResults as $user)
                            <li x-data="{ showPopover: false }" class="relative w-full ">
                                <button
                                    class="flex justify-center items-center  px-4 py-2 text-white  hover:bg-[#1F2937] rounded-b-2xl
                                            focus:outline-none  transition-colors  ease-in-out duration-50 w-full"
                                    {{-- x-on:click="searchResultClicked('{{ $user->first_name }} {{ $user->last_name }}', '{{ $user->patient_id }}')" --}} x-on:mouseenter="showPopover = true"
                                    x-on:mouseleave="showPopover = false">
                                    <img class="object-cover w-8 h-8 rounded-full"
                                        src="{{ $this->getUserProfilePhotoUrl($user->profile_photo_path, $user->username, $user->first_name) }}"
                                        alt="" aria-hidden="true" />
                                    <span class="mr-2" aria-hidden="true">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                        <span class="block text-sm text-gray-300" aria-hidden="true">
                                            {{ $user->phone }}
                                        </span>
                                        @if ($user->other_phone)
                                            <span class="block text-sm text-gray-300" aria-hidden="true">
                                                {{ $user->other_phone ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </span>
                                </button>
                                <div x-show="showPopover" x-on:mouseenter="showPopover = true"
                                    x-on:mouseleave="showPopover = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-90"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-90"
                                    class="absolute top-full transform-gpu w-full lg:top-0 lg:right-full lg:w-80 bg-c-gray-800 shadow-lg rounded-lg p-4 text-purple-200 z-10">
                                    <p class="font-medium leading-relaxed">
                                        الاسم : {{ $user->first_name }} {{ $user->last_name }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        رقم الهاتف : {{ $user->phone }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        رقم الهاتف الاضافي :
                                        {{ $user->other_phone ?? '[غير مسجل]' }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        العيادة : {{ $user->clinic_name }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        السن : {{ $user->age }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        الجنس : {{ UserInfoEnum::genderLabel($user->gender) }}
                                    </p>
                                    <p class="text-sm leading-relaxed">
                                        العنوان : {{ $user->address ?? '[غير مسجل]' }}
                                    </p>
                                    {{-- <p class="text-sm">Joined: {{ $user->created_at->format('M d, Y') }}</p> --}}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="w-full my-4">
                    <x-select :items="['patient' => 'مريض', 'appointment' => 'موعد', 'doctor' => 'طبيب']" label="اختيار نوع البحث" withError="searchType" wire:model="searchType"
                        class="bg-gray-100"></x-select>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button @click="{{ $show }} = false" wire:loading.attr="disabled">
                {{ __('اغلاق') }}
            </x-danger-button>
        </x-slot>
    </x-modals.modal>
</div>
@push('scripts')
    <script>
        function receptionGlobalSearchModal() {
            return {
                showReceptionSearchModal: false,
            }
        }
    </script>
@endpush
