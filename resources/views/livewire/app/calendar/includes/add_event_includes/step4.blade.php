@php
    use App\Formatters\MoneyFormatter;
    use App\Enums\Helpers\HelperEnum;
@endphp
<div x-transition:enter x-show="step == 4">
    <div class="flex flex-wrap">
        <div class="p-2">
            تأكيد الفاتورة هل هي مدفوعة ام لا
            <input type="hidden" wire:model="invoiceView.event_id">
        </div>
        <x-cells.cell label="اسم المريض" :border="false" class="w-full md:w-full">
            <span class="text-sm">
                {{ $invoiceView['patient_name'] ?? HelperEnum::NOT_AVAILABLE->label() }}
            </span>
        </x-cells.cell>
        <x-cells.cell label="خدمة الحجز" class="w-full md:w-full">
            <span class="text-sm">
                {{ $invoiceView['clinic_service_name'] ?? HelperEnum::NOT_AVAILABLE->label() }}
            </span>
        </x-cells.cell>
        <x-cells.cell label="دكتور الحجز" class="w-full md:w-full">
            <span class="text-sm">
                {{ $invoiceView['doctor_name'] ?? HelperEnum::NOT_AVAILABLE->label() }}
            </span>
        </x-cells.cell>
        <x-cells.cell label="المبلغ المطلوب" class="w-full md:w-full">
            <span class="text-red-600 text-sm">
                {{ MoneyFormatter::format($invoiceView['price'] ?? null) }}
            </span>
        </x-cells.cell>
        <x-cells.cell label="المبلغ المدفوع" class="w-full md:w-full">
            <span class="w-full block ">
                <x-input type="number" id="paid_price" wire:model="paid_price" withError="paid_price"
                    class=" bg-gray-100 px-4 rounded text-gray-600 w-full break-all" autofocus autocomplete="off"
                    autocorrect="off" autocapitalize="off" spellcheck="false" />
            </span>
        </x-cells.cell>
        {{-- <div class="mt-4 w-full  px-2">
            <label>
                المبلغ المدفوع
                <span class="text-red-600">*</span>
            </label>
            <x-input type="number" id="paid_price" wire:model="paid_price" withError="paid_price"
                class="mt-4 bg-gray-100 px-4 py-2 rounded  text-sm text-gray-500 w-full break-all" autofocus
                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        </div> --}}
    </div>
</div>
