@php
    use Carbon\Carbon;
@endphp
<div>
    <x-datatable.table :total="$doctors->total()">
        <x-slot name="thead">
            <div class="flex justify-between mb-4">
                <livewire:app.doctor.includes.create-doctor-modal :clinics="$clinics"></livewire:app.doctor.includes.create-doctor-modal>
            </div>
            <x-datatable.thead :headers="__('datatable.clinic_table')" :iterator="true" :sorting="true"></x-datatable.thead>
        </x-slot>
        <x-datatable.tbody>
            @foreach ($doctors as $doctor)
                <x-datatable.trow>
                    <td class="px-4 py-3">
                        @iteration($doctors)
                    </td>
                    <x-datatable.tdata.actions :name="$doctor->user->username">
                        <div x-data="updateModal" x-on:updated="show = false">
                            <x-datatable.tdata.link href="#" @click="show = true">
                                <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                تعديل
                            </x-datatable.tdata.link>
                            <div class="text-right">
                                <livewire:app.doctor.includes.update-doctor-modal :key="now() . random_int(1, 999999)" :doctor="$doctor"
                                    :clinics="$clinics">
                                </livewire:app.doctor.includes.update-doctor-modal>
                            </div>
                        </div>
                        <x-datatable.tdata.link href="#">
                            <i class="fa-solid fa-database fa-lg px-2"></i>
                            تفاصيل
                        </x-datatable.tdata.link>
                        <div x-data="deleteData">
                            <x-datatable.tdata.link href="#"
                                x-on:click="confirmedDelete('{{ $doctor->user->first_name }}', '{{ $doctor->id }}')"
                                class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                <i class="fa-solid fa-trash fa-lg px-2"></i>
                                حذف
                            </x-datatable.tdata.link>
                        </div>
                    </x-datatable.tdata.actions>
                    <td class="px-4 py-3">
                        {{ $doctor->specialization }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $doctor->clinic->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $doctor->user->phone }}
                    </td>
                    <td class="px-4 py-3" dir="ltr">
                        {{ Carbon::parse($doctor->created_at)->format('d/m/Y - h:ia ') }}
                    </td>
                </x-datatable.trow>
            @endforeach
        </x-datatable.tbody>

    </x-datatable.table>

    <x-datatable.pagination :paginator="$doctors"></x-datatable.pagination>

</div>
@push('scripts')
    <script>
        function deleteData() {
            return {
                confirmedDelete(name, doctorId) {
                    let title = "هل أنت متأكد من حذف الطبيب " + name + " ؟";
                    let text = "سوف يتم حذف هذه الطبيب نهائياً!";
                    confirmDelete(title, text).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteDoctorAction', doctorId)
                        }
                    });
                }
            }
        }
    </script>
@endpush
