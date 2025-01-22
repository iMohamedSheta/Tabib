@php
    use Carbon\Carbon;
    use App\Enums\Helpers\HelperEnum;
    use App\Formatters\MoneyFormatter;
@endphp
<div>
    <x-modals.modal @keydown.escape.window="show = false" maxWidth="2xl">
        <x-slot name="title">
            بيانات الخدمة الطبية
        </x-slot>

        <x-slot name="content">

            <h3 class="pb-2">
                بيانات الخدمة الطبية - {{ $clinicService->name }}
            </h3>
            <div class="flex flex-wrap bg-c-gray-800 text-gray-100 rounded-lg text-center">
                <div class=" border-gray-100 w-full">
                    <dl class="divide-y divide-gray-100 py-8 px-6 border-b  border-gray-300">
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-semibold ">
                                اسم الخدمة الطبية
                            </dt>
                            <dd class="mt-1 text-sm/6  sm:col-span-2 sm:mt-0">
                                {{ $clinicService->name }}
                            </dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-semibold ">
                                السعر
                            </dt>
                            <dd class="mt-1 text-sm/6  sm:col-span-2 sm:mt-0">
                                {{ MoneyFormatter::format($clinicService->price) }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-semibold ">
                                العيادة
                            </dt>
                            <dd class="mt-1 text-sm/6  sm:col-span-2 sm:mt-0">
                                {{ $clinicService->clinic_name ?? 'جميع العيادات' }}
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-semibold ">
                                اللون المميز
                            </dt>
                            <dd class="mt-1 flex items-center justify-center  text-sm/6  sm:col-span-2 sm:mt-0">
                                <span class="flex w-8 h-8 rounded-full mx-2"
                                    style="background-color:{{ $clinicService->color }}">
                                </span>
                                <span class="p-2 rounded-full text-white"
                                    style="background-color:{{ $clinicService->color }}">
                                    {{ $clinicService->color ?? HelperEnum::NOT_AVAILABLE->label() }}
                                </span>
                            </dd>
                        </div>
                        <div class="px-4 py-3  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-semibold ">
                                وصف الخدمة الطبية
                            </dt>
                            <dd class="mt-1 text-sm/6  sm:col-span-2 sm:mt-0">
                                {{ $clinicService->description ?? HelperEnum::NOT_AVAILABLE->label() }}
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
