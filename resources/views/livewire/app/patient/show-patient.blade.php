@php
    use App\Enums\Helpers\HelperEnum;
@endphp
<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    {{-- <x-main.head wire:ignore icon="{{ $patient->user->profile_photo_url }}">
        <x-slot name="title">
            المريض :
            {{ $patient->user->first_name . ' ' . $patient->user->last_name }}
        </x-slot>
        <x-slot name="body">
            <div class="text-purple-200 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium ">
                    رقم الهاتف :
                </dt>
                <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                    {{ $patient->user->phone }}
                </dd>
            </div>
            <div class="text-purple-200 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium ">
                    رقم الهاتف الاضافي :
                </dt>
                <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                    {{ $patient->user->other_phone ?: HelperEnum::NOT_AVAILABLE->label() }}
                </dd>
            </div>
        </x-slot>
    </x-main.head> --}}
    <div
        class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <div class="flex bg-c-gray-700 rounded">
            <div class="bg-purple-500 rounded-xl w-full">
                <div
                    class="text-xl w-full bg-c-gray-700 border-dashed border drop-shadow-xl  border-gray-500 shadow-md   group transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl p-6 rounded-xl inline-flex  items-center ">
                    <img src="{{ $icon ?? asset('images/doctors/icon.png') }}" alt="Doctor Icon"
                        class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 shadow-md">
                    <div class="md:px-4 pr-3">
                        <div class="flex">
                            المريض :
                            {{ $patient->user->first_name . ' ' . $patient->user->last_name }}
                            <span class="text-sm text-purple-300 flex mx-4">
                                [
                                {{ $patient->puid }}
                                ]
                            </span>
                        </div>
                        <p
                            class=" md:max-w-[95%] text-gray-600 dark:text-gray-300 text-sm md:px-2 pr-1 pt-3 leading-relaxed">
                        <div class="text-purple-200 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium ">
                                رقم الهاتف :
                            </dt>
                            <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                                {{ $patient->user->phone }}
                            </dd>
                        </div>
                        <div class="text-purple-200 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium ">
                                رقم الهاتف الاضافي :
                            </dt>
                            <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                                {{ $patient->user->other_phone ?: HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <x-tabs.tab-list selected-tab="exams" :patient="$patient">
            {{-- <x-tabs.tab-list selected-tab="medical_records"> --}}
            <x-slot name="tabs">
                @foreach (config('patient.view.show-patient.tabs') as $tabKey => $tab)
                    <x-tabs.tab-head :name="$tabKey">
                        <i class="{{ $tab['icon'] }}"></i>
                        {{ __($tab['trans_key']) }}
                    </x-tabs.tab-head>
                @endforeach
            </x-slot>
            @foreach (config('patient.view.show-patient.tabs') as $tabKey => $tab)
                <x-tabs.tab :name="$tabKey">
                    <div class="my-6 mx-4 p-6 border border-gray-600 border-dashed rounded-xl">
                        @if (isset($tab['file']))
                            @include($tab['file'])
                        @endif
                    </div>
                </x-tabs.tab>
            @endforeach
        </x-tabs.tab-list>
    </div>
</div>
