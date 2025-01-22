@php
    use App\Enums\User\UserInfoEnum;
@endphp
<div x-transition:enter x-show="step == 3">
    <div class="flex flex-wrap">
        <x-search.live-search label="اسم المريض" wireModel="search" hiddenWireModel="patient_id" :searchResults="$searchResults"
            :idValue="$patient_id">
            @foreach ($searchResults as $user)
                <li x-data="{ showPopover: false }" class="relative w-full ">
                    <button
                        class="flex justify-center items-center  px-4 py-2 text-white  hover:bg-[#1F2937] rounded-b-2xl
    focus:outline-none  transition-colors  ease-in-out duration-50 w-full"
                        x-on:click="searchResultClicked('{{ $user->first_name }} {{ $user->last_name }}', '{{ $user->patient_id }}')"
                        x-on:mouseenter="showPopover = true" x-on:mouseleave="showPopover = false">
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
                    <div x-show="showPopover" x-on:mouseenter="showPopover = true" x-on:mouseleave="showPopover = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
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

                    </div>
                </li>
            @endforeach
        </x-search.live-search>

        <x-search.live-search label="اسم الدكتور" wireModel="searchDoctor" hiddenWireModel="doctor_id" :searchResults="$searchDoctorResults"
            :idValue="$doctor_id">
            @foreach ($searchDoctorResults as $user)
                <li x-data="{ showPopover: false }" class="relative w-full ">
                    <button
                        class="flex justify-center items-center  px-4 py-2 text-white  hover:bg-[#1F2937] rounded-b-2xl
            focus:outline-none  transition-colors  ease-in-out duration-50 w-full"
                        x-on:click="searchResultClicked('{{ $user->first_name }} {{ $user->last_name }}', '{{ $user->doctor_id }}')"
                        x-on:mouseenter="showPopover = true" x-on:mouseleave="showPopover = false">
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
                </li>
            @endforeach
        </x-search.live-search>

        <div class="mt-6 w-full px-2">
            <label>
                العيادة
                <span class="text-red-600">*</span>
            </label>
            <x-select.select label="اختيار العيادة" withError="clinic_id" :items="$clinics" wire:model="clinic_id"
                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
            </x-select.select>
        </div>
        <div class="mt-6 mb-3 w-full px-2">
            <label>
                نوع الخدمة
                <span class="text-red-600">*</span>
            </label>
            <x-select.select label="اختيار الخدمة" withError="service_id" :items="$clinicServices" wire:model="service_id"
                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
            </x-select.select>
        </div>
    </div>
</div>
