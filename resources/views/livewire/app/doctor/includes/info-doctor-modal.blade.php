@php
    use Carbon\Carbon;
    use App\Enums\Helpers\HelperEnum;
@endphp
<div>
    <x-modals.modal @keydown.escape.window="show = false" maxWidth="4xl">
        <x-slot name="title">
            بيانات الطبيب
        </x-slot>

        <x-slot name="content">

            <h3 class="pb-2">
                بيانات الطبيب - {{ $doctor->fullname }}
            </h3>
            <div class="flex flex-wrap">
                <div class=" border-gray-100 w-full">
                    <dl class="divide-y divide-gray-100 py-8 px-6 border-b ">
                        <div class="pb-4 border-b  ">
                            <img src="{{ $doctor->profile_photo_url }}"
                                class="mx-auto mb-1 w-40 h-40 rounded-full object-cover">
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                اسم الدكتور
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->fullname }}
                            </dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                التخصص
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->specialization }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                اسم الجهة
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->organization_name }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                رقم الهاتف
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->phone }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                رقم الهاتف الاضافي
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->other_phone ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                الحالة
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->is_active ? 'مفعل' : 'غير مفعل' ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                اسم المستخدم
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->username ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                البريد الالكتروني
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->email ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                اخر اتصال بالنظام
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ Carbon::parse($doctor->last_connect)->diffForHumans() ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900">
                                الوصف
                            </dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $doctor->biography ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button @click="show = false" wire:loading.attr="disabled">
                {{ __('اغلاق') }}
            </x-danger-button>
        </x-slot>
    </x-modals.modal>
</div>

@push('scripts')
    <script>
        function infoModal() {
            return {
                show: false,
            }
        }
    </script>
@endpush
