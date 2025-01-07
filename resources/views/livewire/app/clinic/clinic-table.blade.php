@php
    use App\Enums\Clinic\ClinicTypeEnum;
    use Carbon\Carbon;
@endphp
<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    <x-main.head wire:ignore :icon="asset('images/clinics/icon.png')">
        <x-slot name="title">
            العيادات
        </x-slot>
        <x-slot name="body">
            العيادات، التي تمثل الفروع المختلفة و العيادة الرئيسية، تتيح لك هذه الصفحة إدارة جميع العيادات المتاحة في
            النظام. يمكنك من خلالها إضافة فروع جديدة، تعديل معلومات الفروع الحالية، أو حذف الفروع غير النشطة. لكل فرع
            سجل خاص يمكّنك من تتبع نشاطه، وحالات المرضى، ومعلومات الأطباء العاملين به، مما يسهل إدارة وتنظيم العمل في
            مختلف الفروع بشكل فعّال.
        </x-slot>
    </x-main.head>
    <div
        class="w-full bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl ">
        <div>
            <x-datatable.table :total="$clinics->total()">
                <x-slot name="thead">
                    <div class="flex justify-between mb-4">
                        <livewire:app.clinic.includes.create-clinic-modal
                            :clinics="$clinics"></livewire:app.clinic.includes.create-clinic-modal>
                    </div>
                    <x-datatable.thead :headers="__('datatable.clinic_table')" :iterator="true" :sorting="true"></x-datatable.thead>
                </x-slot>
                <x-datatable.tbody>
                    @foreach ($clinics as $clinic)
                        <x-datatable.trow>
                            <td class="px-4 py-3">
                                @iteration($clinics)
                            </td>
                            <x-datatable.tdata.actions :name="$clinic->name">
                                <div x-data="updateModal" x-on:updated="show = false">
                                    <x-datatable.tdata.link href="#" @click="show = true">
                                        <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                        تعديل
                                    </x-datatable.tdata.link>
                                    <div class="text-right">
                                        {{-- <livewire:app.clinic.includes.update-clinic-modal :key="now() . random_int(1, 999999)" :clinic="$clinic"
                                    :clinics="$clinics">
                                </livewire:app.clinic.includes.update-clinic-modal> --}}
                                    </div>
                                </div>
                                <div x-data="infoModal" x-on:updated="show = false">
                                    <x-datatable.tdata.link href="#" @click="show = true">
                                        <i class="fa-solid fa-database fa-lg px-2"></i>
                                        تفاصيل
                                    </x-datatable.tdata.link>
                                    <div class="text-right">
                                        {{-- <livewire:app.clinic.includes.info-clinic-modal :key="now() . random_int(1, 999999)" :clinic="$clinic"
                                    :clinics="$clinics">
                                </livewire:app.clinic.includes.info-clinic-modal> --}}
                                    </div>
                                </div>

                                <div x-data="deleteData">
                                    <x-datatable.tdata.link href="#"
                                        x-on:click="confirmedDelete('{{ $clinic->name }}', '{{ $clinic->id }}')"
                                        class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                        <i class="fa-solid fa-trash fa-lg px-2"></i>
                                        حذف
                                    </x-datatable.tdata.link>
                                </div>
                            </x-datatable.tdata.actions>
                            <td class="px-4 py-3">
                                {{ ClinicTypeEnum::matchClinicTypeLabel($clinic->type) }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $clinic->code }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $clinic->plan_name }}
                            </td>
                            <td class="px-4 py-3" dir="ltr">
                                {{ Carbon::parse($clinic->created_at)->format('d/m/Y - h:ia ') }}
                            </td>
                        </x-datatable.trow>
                    @endforeach
                </x-datatable.tbody>

            </x-datatable.table>

            <x-datatable.pagination :paginator="$clinics"></x-datatable.pagination>
        </div>
    </div>
</div>

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
