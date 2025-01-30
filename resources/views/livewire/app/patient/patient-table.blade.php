@php
    use Carbon\Carbon;
@endphp

<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    {{-- <x-main.head wire:ignore>
        <x-slot name="title">
            المرضي
        </x-slot>
        <x-slot name="body">
            تتيح لك هذه الصفحة إدارة المرضى المسجلين في العيادة، حيث يمكنك بسهولة إضافة مرضى جدد إلى النظام، تعديل
            بيانات المرضى الحاليين، أو حذف المرضى غير النشطين. يحتوي كل مريض على ملف خاص داخل النظام يمكّنك من متابعة
            معلوماته الطبية وسجلاته الصحية بشكل شامل ومنظم.
        </x-slot>
    </x-main.head> --}}
    <div
        class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <x-datatable.table :total="$patients->total()">
            <x-slot name="thead">
                <div class="flex justify-between mb-4" x-data="addModal" x-on:added="show = false">
                    <livewire:app.patient.includes.create-patient-modal
                        :clinics="$clinics"></livewire:app.patient.includes.create-patient-modal>
                    <div class="w-1/2 flex justify-end">
                        <x-input wire:model.live.debounce.500ms="search" placeholder="بحث"
                            class="py-1 text-xs mt-2 w-1/3 text-gray-600 min-w-[200px] bg-purple-200" />
                    </div>
                </div>
                <x-datatable.thead :headers="__('datatable.patient_table')" :iterator="true" :sorting="true"></x-datatable.thead>
            </x-slot>
            <x-datatable.tbody>
                @foreach ($patients as $patient)
                    <x-datatable.trow>
                        <td class="px-4 py-3">
                            @iteration($patients)
                        </td>
                        <x-datatable.tdata.actions :name='"{$patient->first_name}  {$patient->last_name}"'>
                            <div x-data="updateModal" x-on:updated="show = false">
                                <x-datatable.tdata.link href="#" @click="show = true">
                                    <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                    تعديل
                                </x-datatable.tdata.link>
                                {{-- <div class="text-right">
                                <livewire:app.patient.includes.update-patient-modal :key="now() . random_int(1, 999999)" :patient="$patient"
                                    :patients="$patients">
                                </livewire:app.patient.includes.update-patient-modal>
                            </div> --}}
                            </div>
                            <div x-data="infoModal" x-on:updated="show = false">
                                <x-datatable.tdata.link wire:navigate.hover
                                    href="{{ route('app.admin.patient.show', ['patient' => $patient->patient_id]) }}"
                                    @click="show = true">
                                    <i class="fa-solid fa-database fa-lg px-2"></i>
                                    تفاصيل
                                </x-datatable.tdata.link>
                                {{-- <div class="text-right">
                                <livewire:app.patient.includes.info-patient-modal :key="now() . random_int(1, 999999)" :patient="$patient"
                                    :patients="$patients">
                                </livewire:app.patient.includes.info-patient-modal>
                            </div> --}}
                            </div>

                            <div x-data="deleteData">
                                <x-datatable.tdata.link href="#"
                                    x-on:click="confirmedDelete('{{ $patient->first_name }}', '{{ $patient->patient_id }}')"
                                    class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                    <i class="fa-solid fa-trash fa-lg px-2"></i>
                                    حذف
                                </x-datatable.tdata.link>
                            </div>
                        </x-datatable.tdata.actions>
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <x-copy-clipboard>
                                    {{ $patient->puid }}
                                </x-copy-clipboard>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            {{ $patient->clinic_name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $patient->phone }}
                        </td>
                        <td class="px-4 py-3">
                            {{ Carbon::parse($patient->created_at)->translatedFormat('d/m/Y - h:ia ') }}
                        </td>
                    </x-datatable.trow>
                @endforeach
            </x-datatable.tbody>

        </x-datatable.table>

        <x-datatable.pagination :paginator="$patients"></x-datatable.pagination>
    </div>
</div>
@push('scripts')
    <script>
        function deleteData() {
            return {
                confirmedDelete(name, patientId) {
                    let title = "هل أنت متأكد من حذف المريض " + name + " ؟";
                    let text = "سوف يتم حذف هذه المريض نهائياً!";
                    confirmDelete(title, text).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deletePatientAction', patientId)
                        }
                    });
                }
            }
        }
    </script>
@endpush
