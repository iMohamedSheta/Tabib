@php
    use Carbon\Carbon;
@endphp

<div class="md:container py-6 mx-auto grid my-6 text-gray-700 dark:text-gray-200">
    <x-main.head wire:ignore>
        <x-slot name="title">
            طوابير الكشوفات - Queue
        </x-slot>
        <x-slot name="body">
            في هذه الصفحة، يمكنك التحكم بطوابير الكشوفات الخاصة بالمرضى في العيادة. توفر لك الأدوات اللازمة لإضافة
            كشوفات جديدة، تعديل الكشوفات الحالية، أو حذف الكشوفات التي لم تعد ضرورية. تتيح لك إدارة طوابير الكشوفات
            متابعة وتنظيم مواعيد المرضى بشكل دقيق، مما يسهم في تقديم خدمات طبية فعالة وسلسة.
        </x-slot>
    </x-main.head>

    <div class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <x-datatable.table :total="$queues?->total() ?? 0">
            <x-slot name="thead">
                <div class="flex justify-between mb-4" x-data="addModal" x-on:added="show = false">
                    <livewire:app.patient.includes.create-patient-modal
                        :clinics="$clinics"></livewire:app.patient.includes.create-patient-modal>
                </div>
                <x-datatable.thead :headers="__('datatable.patient_table')" :iterator="true" :sorting="true"></x-datatable.thead>
            </x-slot>
            <x-datatable.tbody>
                @foreach ($queues as $patient)
                    <x-datatable.trow>
                        <td class="px-4 py-3">
                            @iteration($queues)
                        </td>
                        <x-datatable.tdata.actions :name="$patient->user->firstname">
                            <div x-data="updateModal" x-on:updated="show = false">
                                <x-datatable.tdata.link href="#" @click="show = true">
                                    <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                    تعديل
                                </x-datatable.tdata.link>
                                {{-- <div class="text-right">
                                <livewire:app.patient.includes.update-patient-modal :key="now() . random_int(1, 999999)" :patient="$patient"
                                    :queues="$queues">
                                </livewire:app.patient.includes.update-patient-modal>
                            </div> --}}
                            </div>
                            <div x-data="infoModal" x-on:updated="show = false">
                                <x-datatable.tdata.link href="#" @click="show = true">
                                    <i class="fa-solid fa-database fa-lg px-2"></i>
                                    تفاصيل
                                </x-datatable.tdata.link>
                                {{-- <div class="text-right">
                                <livewire:app.patient.includes.info-patient-modal :key="now() . random_int(1, 999999)" :patient="$patient"
                                    :queues="$queues">
                                </livewire:app.patient.includes.info-patient-modal>
                            </div> --}}
                            </div>

                            <div x-data="deleteData">
                                <x-datatable.tdata.link href="#"
                                    x-on:click="confirmedDelete('{{ $patient->user->firstname }}', '{{ $patient->id }}')"
                                    class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                    <i class="fa-solid fa-trash fa-lg px-2"></i>
                                    حذف
                                </x-datatable.tdata.link>
                            </div>
                        </x-datatable.tdata.actions>
                        <td class="px-4 py-3">
                            {{ $patient->clinic->name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $patient->user->phone }}
                        </td>
                        <td class="px-4 py-3" dir="ltr">
                            {{ Carbon::parse($patient->created_at)->format('d/m/Y - h:ia ') }}
                        </td>
                    </x-datatable.trow>
                @endforeach
            </x-datatable.tbody>

        </x-datatable.table>

        <x-datatable.pagination :paginator="$queues"></x-datatable.pagination>
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
                            @this.call('deletepatientAction', patientId)
                        }
                    });
                }
            }
        }
    </script>
@endpush
