<div x-transition:enter x-show="step == 2">
    <h3 class="pb-2">
        من فضلك ادخل بيانات المريض
    </h3>
    <div class="flex flex-wrap">
        <div class="mt-4 w-full md:w-1/2 px-2">
            <label>
                الاسم الاول
                <span class="text-red-600">*</span>
            </label>
            <x-input type="text" id="first_name" wire:model="first_name" withError="first_name"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="mt-4 w-full md:w-1/2 px-2">
            <label>
                اسم العائلة
                <span class="text-red-600">*</span>
            </label>
            <x-input type="text" id="last_name" wire:model="last_name" withError="last_name"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="mt-4 w-full md:w-1/2 px-2">
            <label>
                رقم الهاتف
                <span class="text-red-600">*</span>
            </label>
            <x-input type="text" id="phone" wire:model="phone" withError="phone"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="mt-4 w-full md:w-1/2 px-2">
            <label>
                رقم الهاتف الاضافي
            </label>
            <x-input type="text" id="other_phone" wire:model="other_phone" withError="other_phone"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="mt-4 w-full md:w-1/3 px-2">
            <label>
                السن
                <span class="text-red-600">*</span>
            </label>
            <x-input type="number" id="age" wire:model="age" withError="age"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="mt-6 w-full md:w-1/3 px-2">
            <label>
                العيادة
                <span class="text-red-600">*</span>
            </label>
            <x-select.select label="اختيار العيادة" withError="clinic_id" :items="$clinics" wire:model="clinic_id"
                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
            </x-select.select>
        </div>
        <div class="mt-6 w-full md:w-1/3 px-2">
            <label>
                الجنس
                <span class="text-red-600">*</span>
            </label>
            <x-select.select label="اختيار النوع" withError="gender" :items="['male' => 'ذكر', 'female' => 'انثى']" wire:model="gender"
                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
            </x-select.select>
        </div>
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
        <div class="w-full  px-2 mt-4 hidden">
            <label>
                عنوان المهمة
                <span class="text-red-600">*</span>
            </label>
            <x-input type="text" id="title" wire:model="title" withError="title"
                class="mt-4 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div>
        <div class="w-full  px-2 mt-4  hidden">
            <label>
                التاريخ
                <span class="text-red-600">*</span>
            </label>
            <input type="date" id="datepicker" wire:ignore x-model="start" wire:model="start"
                class='border-gray-300  focus:border-indigo-500 mt-4 bg-gray-100 px-4 py-2  text-sm text-gray-500 w-full break-all focus:ring-indigo-500 rounded shadow-sm' />
        </div>

        <div class="mt-6 w-full px-2">
            <label>
                نوع الخدمة
                <span class="text-red-600">*</span>
            </label>
            <x-select.select label="اختيار الخدمة" withError="service_id" :items="$clinicServices" wire:model="service_id"
                class="mt-2 bg-gray-100 px-4 py-2 rounded text-sm text-gray-500 w-full break-all">
            </x-select.select>
        </div>

        <div>
            <input type="hidden" x-on:update-all-day.window="$wire.set('allDay', $event.detail)" />
        </div>
    </div>
</div>
