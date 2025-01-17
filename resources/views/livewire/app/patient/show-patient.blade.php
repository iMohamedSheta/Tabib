@php
    use App\Enums\Helpers\HelperEnum;
@endphp
<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    <x-main.head wire:ignore icon="{{ $patient->user->profile_photo_url }}">
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
    </x-main.head>
    <div
        class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <x-tabs.tab-list selected-tab="medical_records">
            {{-- <x-tabs.tab-list selected-tab="attached_files"> --}}
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
