@php
    use App\Enums\Clinic\ClinicTypeEnum;
    use Carbon\Carbon;
@endphp
<x-datatable.table :total="1">
    <x-slot name="thead">
    <x-datatable.thead :headers="__('datatable.clinic_table')" :iterator="true" :sorting="true"></x-datatable.thead>
    </x-slot>
    <x-datatable.tbody>

        @forelse ( $clinics as $clinic)
            <x-datatable.trow>
                <td class="px-4 py-3">
                    1
                </td>
                <x-datatable.tdata.actions :name="$clinic->name">
                    <x-datatable.tdata.link href="#">
                        <i class="fa-solid fa-pen-to-square fa-lg px-2"></i>
                        تعديل
                    </x-datatable.tdata.link>
                    <x-datatable.tdata.link href="#">
                        <i class="fa-solid fa-database fa-lg px-2"></i>
                        تفاصيل
                    </x-datatable.tdata.link>
                    <div x-data="deleteData">
                        <x-datatable.tdata.link href="#" @click="confirmedDelete" class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                            <i class="fa-solid fa-trash fa-lg px-2"></i>
                            حذف
                        </x-datatable.tdata.link>
                    </div>
                </x-datatable.tdata.actions>
                <td class="px-4 py-3 ">
                    {{ ClinicTypeEnum::matchClinicTypeLabels($clinic->type) }}
                </td>
                <td class="px-4 py-3">
                    <span
                        class="px-2 py-1  leading-tight text-green-700 bg-green-100 rounded-full dark:bg-purple-600 dark:text-green-100">
                        {{ $clinic->billing_code }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    {{ Carbon::parse($clinic->created_at)->diffForHumans() }}
                </td>

            </x-datatable.trow>
        @empty

        @endforelse
    </x-datatable.tbody>
</x-datatable.table>

@push('scripts')
<script>
    function deleteData() {
        return {
            confirmedDelete() {
                let title = "هل أنت متأكد من حذف العيادة؟";
                let text = "سوف يتم حذف هذه العيادة نهائياً!";
                confirmDelete(title, text).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete')
                    }
                });
            }
        }
    }

</script>
@endpush
