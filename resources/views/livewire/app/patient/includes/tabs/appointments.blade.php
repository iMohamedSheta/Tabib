<p class="px-4 py-8">
    الحجوزات هي مكان يمكن فيه رؤية جميع المواعيد التي تم حجزها للمريض، سواء كانت مواعيد سابقة أو
    مستقبلية، مع تفاصيل مثل تاريخ ووقت الحجز، اسم الطبيب، والعيادة.
<div class="flex flex-wrap">
    {{-- @foreach ($patient->appointments as $appointment)
    <x-cells.cell label="تاريخ الحجز">
        {{ DateFormatter::detailed($appointment->date) }}
    </x-cells.cell>
    <x-cells.cell label="وقت الحجز">
        {{ $appointment->time }}
    </x-cells.cell>
    <x-cells.cell label="اسم الطبيب">
        {{ $appointment->doctor->name }}
    </x-cells.cell>
    <x-cells.cell label="العيادة">
        {{ $appointment->clinic->name }}
    </x-cells.cell>
@endforeach --}}
</div>
</p>
