@php
    use App\Enums\Clinic\ClinicTypeEnum;
    use App\Enums\User\UserInfoEnum;
@endphp
<div>
    <x-modals.modal @keydown.escape.window="{{ $show }} = false" show="{{ $show }}" maxWidth="4xl"
        :withPadding="false" class="bg-c-gray-800 opacity-95">
        {{-- <x-slot name="title">
            <span class="text-gray-200">
                بيانات الخدمات الطبية العامة
            </span>
        </x-slot> --}}

        <x-slot name="content">

            {{-- <h3 class="pb-2 text-gray-300">
                البحث فى الخدمات الطبية العامة للبحث عن مريض او موعد او طبيب...الخ.
            </h3> --}}
            <div class="flex flex-wrap  ">
                <div class="w-full flex items-center bg-c-gray-600">
                    <i class="fa fa-search fa-xl px-6"></i>
                    <x-input wire:model.live.debounce.500ms="search" type="text"
                        class=" bg-c-gray-700  py-6 focus:ring-0  rounded-sm text-xs text-gray-300 w-full break-all border-0"
                        placeholder="ادخل اسم الخدمة الطبية" />
                </div>

                <div class="w-full">
                    {{-- <ul class="bg-[#111827] rounded-b-2xl"> --}}
                    <ul class="bg-c-gray-800 rounded-b-2xl">
                        @foreach ($searchResults as $user)
                            <li x-data="{ showPopover: false }" class="relative w-full ">
                                <a href="{{ $this->getSearchResultUrl($user->patient_id) }}" wire:navigate.hover
                                    class="flex justify-center items-center  px-4 py-2 text-white  hover:bg-c-gray-700 rounded-b-2xl
                                            focus:outline-none  transition-colors  ease-in-out duration-50 w-full"
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
                                </a>
                                <div x-show="showPopover" x-on:mouseenter="showPopover = true"
                                    x-on:mouseleave="showPopover = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-90"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-90"
                                    class="absolute top-full text-center transform-gpu w-full lg:top-0 lg:right-full lg:w-80 bg-c-gray-700 shadow-lg rounded-sm p-4 text-gray-300 z-10">
                                    <p class="text-xs leading-relaxed">
                                        الاسم : {{ $user->first_name }} {{ $user->last_name }}
                                    </p>
                                    <p class="text-xm leading-relaxed">
                                        رقم الهاتف : {{ $user->phone }}
                                    </p>
                                    <p class="text-xs leading-relaxed">
                                        رقم الهاتف الاضافي :
                                        {{ $user->other_phone ?? '[غير مسجل]' }}
                                    </p>
                                    <p class="text-xs leading-relaxed">
                                        العيادة : {{ $user->clinic_name }}
                                    </p>
                                    <p class="text-xs leading-relaxed">
                                        السن : {{ $user->age }}
                                    </p>
                                    <p class="text-xs leading-relaxed">
                                        الجنس : {{ UserInfoEnum::genderLabel($user->gender) }}
                                    </p>
                                    <p class="text-xs leading-relaxed">
                                        العنوان : {{ $user->address ?? '[غير مسجل]' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="w-full my-4">
                    <x-select :items="['patient' => 'مريض', 'appointment' => 'موعد', 'doctor' => 'طبيب']" label="اختيار نوع البحث" withError="searchType" wire:model="searchType"
                        class="mt-2 bg-c-gray-700 px-4 py-2 rounded-sm text-xs text-gray-300 w-full break-all border-0"></x-select>
                </div> --}}
            </div>
            {{--
            <div
                class="fixed inset-0 z-50 flex animate-in flex-col items-center bg-gray-900/80 p-4 backdrop-blur-sm md:pt-[8vh]">
                <div
                    class="mx-auto flex max-h-full w-full max-w-3xl flex-col overflow-hidden rounded-lg border border-gray-800 bg-gray-900 shadow-xl">
                    <!-- Search Header -->
                    <div class="flex items-center px-6">
                        <i class="fa fa-search"></i>
                        <input type="text" placeholder="Ask or search..."
                            class="w-full border-none bg-transparent p-4 text-base text-gray-300 placeholder-gray-500 focus:outline-none">
                    </div>

                    <!-- Content Area -->
                    <div class="flex flex-1 flex-col overflow-y-auto">
                        <div class="mb-4 flex flex-1 flex-col">
                            <div class="flex flex-1 flex-col px-4 pb-4">
                                <!-- Recently searched -->
                                <div class="flex items-end gap-2 p-2">
                                    <div class="text-sm text-gray-400">Recently searched</div>
                                </div>

                                <!-- Recent Items -->
                                <div class="space-y-1">
                                    @foreach (['What is the purpose of parseAiApiResponse method?', 'What does the generateAiFiles method do?'] as $recentSearch)
                                        <button
                                            class="flex w-full items-center gap-2 overflow-hidden rounded-full bg-gray-800/50 px-4 py-3 text-left text-sm text-gray-300 hover:bg-gray-700/50">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 16 16">
                                                <path fill="currentColor" fill-rule="evenodd"
                                                    d="M5.5 12.3a3.8 3.8 0 1 0 0-7.6 3.8 3.8 0 0 0 0 7.6Zm0 1.2a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                                                <path fill="currentColor"
                                                    d="M8.37 12.218a.6.6 0 1 1 .848-.849l2.556 2.556a.6.6 0 0 1-.849.849L8.37 12.218Z" />
                                            </svg>
                                            <span class="truncate">{{ $recentSearch }}</span>
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Suggested for you -->
                                <div class="mt-6 flex items-end gap-2 p-2">
                                    <div class="text-sm text-gray-400">Suggested for you</div>
                                </div>

                                <!-- Suggested Items -->
                                <div class="space-y-1">
                                    @php
                                        $suggestedSearches = [
                                            'What does AiFileGenerationApiTrait do?',
                                            'How does generateAiFiles work?',
                                            'What is the purpose of parseAiApiResponse method?',
                                            'Can generateAiFiles handle any type of response?',
                                            'What type of object does generateAiFiles return?',
                                            'What parameters does generateAiFiles accept?',
                                            'Does generateAiFiles create directories?',
                                            'Is parsedResponse an associative array?',
                                        ];
                                    @endphp

                                    @foreach ($suggestedSearches as $search)
                                        <button
                                            class="flex w-full items-center gap-2 overflow-hidden rounded-full bg-gray-800/50 px-4 py-3 text-left text-sm text-gray-300 hover:bg-gray-700/50">
                                            <span class="truncate">{{ $search }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Search -->
                    <div class="border-t border-gray-800 bg-gray-900/50 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 16 16">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M5.5 12.3a3.8 3.8 0 1 0 0-7.6 3.8 3.8 0 0 0 0 7.6Zm0 1.2a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                                <path fill="currentColor"
                                    d="M8.37 12.218a.6.6 0 1 1 .848-.849l2.556 2.556a.6.6 0 0 1-.849.849L8.37 12.218Z" />
                            </svg>
                            <div class="mx-4 mr-auto text-gray-400">
                                Find an answer using <span class="font-semibold text-gray-300">GitBook AI</span>
                            </div>
                            <button
                                class="rounded-md bg-pink-500 px-4 py-2 text-sm font-medium text-white hover:bg-pink-600">
                                Upgrade to Pro
                            </button>
                        </div>
                    </div>
                </div>
            </div> --}}
        </x-slot>

        {{-- <x-slot name="footer">
            <div class="flex justify-end gap-2 px-6 py-4">
                <x-danger-button @click="{{ $show }} = false" wire:loading.attr="disabled">
                    {{ __('اغلاق') }}
                </x-danger-button>
            </div>
        </x-slot> --}}
    </x-modals.modal>
</div>
