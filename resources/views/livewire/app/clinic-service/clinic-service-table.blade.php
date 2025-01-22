@php
    use Carbon\Carbon;
    use App\Formatters\MoneyFormatter;
@endphp

<div>
    <div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
        <x-main.head wire:ignore :icon="asset('images/clinic_services/icon.png')">
            <x-slot name="title">
                الخدمات الطبية
            </x-slot>
            <x-slot name="body">
                تتيح لك هذه الصفحة إدارة الخدمات الطبية التي تقدمها العيادة، حيث يمكنك بسهولة إضافة خدمات جديدة، تعديل
                تفاصيل
                الخدمات الحالية، أو حذف الخدمات غير المتوفرة. يوفر النظام عرضًا شاملًا لكل خدمة بما في ذلك وصفها،
                تكلفتها،
                والفئات المستفيدة، مما يساعد على تنظيم وتطوير خدمات العيادة بشكل فعال.
            </x-slot>
        </x-main.head>

        <div
            class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl min-h-[50vh]">
            <x-datatable.table :total="$clinicServices->total()">
                <x-slot name="thead">
                    <div class="flex justify-between mb-4" x-data="addModal" x-on:added="show = false">
                        <livewire:app.clinic-service.includes.create-clinic-service-modal
                            :clinics="$clinics"></livewire:app.clinic-service.includes.create-clinic-service-modal>
                    </div>
                    <x-datatable.thead :headers="__('datatable.clinic_services_table')" :iterator="true" :sorting="true"></x-datatable.thead>
                </x-slot>
                <x-datatable.tbody>
                    @foreach ($clinicServices as $clinicService)
                        <x-datatable.trow>
                            <td class="px-4 py-3">
                                @iteration($clinicServices)
                            </td>
                            <x-datatable.tdata.actions :name="$clinicService->name">
                                <div x-data="updateModal" x-on:updated="showUpdate = false">
                                    <x-datatable.tdata.link href="#" @click="showUpdate = true">
                                        <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                        تعديل
                                    </x-datatable.tdata.link>
                                    @teleport('body')
                                        <div class="text-right">
                                            <livewire:app.clinic-service.includes.update-clinic-service-modal
                                                :key="now() . random_int(1, 999999)" :clinics="$clinics" :clinicService="$clinicService">
                                            </livewire:app.clinic-service.includes.update-clinic-service-modal>
                                        </div>
                                    @endteleport
                                </div>
                                <div x-data="infoModal" x-on:updated="show = false">
                                    <x-datatable.tdata.link href="#" @click="show = true">
                                        <i class="fa-solid fa-database fa-lg px-2"></i>
                                        تفاصيل
                                    </x-datatable.tdata.link>
                                    @teleport('body')
                                        <div class="text-right">
                                            <livewire:app.clinic-service.includes.info-clinic-service-modal
                                                :key="now() . random_int(1, 999999)" :clinicService="$clinicService">
                                            </livewire:app.clinic-service.includes.info-clinic-service-modal>
                                        </div>
                                    @endteleport
                                </div>

                                <div x-data="deleteData">
                                    <x-datatable.tdata.link href="#"
                                        x-on:click="confirmedDelete('{{ $clinicService->name }}', '{{ $clinicService->id }}')"
                                        class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                        <i class="fa-solid fa-trash fa-lg px-2"></i>
                                        حذف
                                    </x-datatable.tdata.link>
                                </div>
                            </x-datatable.tdata.actions>
                            <td class="px-4 py-3">
                                {{ $clinicService->clinic->name ?? 'جميع العيادات' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ MoneyFormatter::format($clinicService->price) }}
                            </td>
                            <td class="px-4 py-3 flex justify-center">
                                <span class="flex w-8 h-8 rounded-full"
                                    style="background-color:{{ $clinicService->color }}">
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ $clinicService->patients_count ?? 0 }}
                            </td>
                            <td class="px-4 py-3" dir="ltr">
                                {{ Carbon::parse($clinicService->created_at)->format('d/m/Y - h:ia ') }}
                            </td>
                        </x-datatable.trow>
                    @endforeach
                </x-datatable.tbody>

            </x-datatable.table>

            <x-datatable.pagination :paginator="$clinicServices"></x-datatable.pagination>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteData() {
            return {
                confirmedDelete(name, clinicServiceId) {
                    let title = "هل أنت متأكد من حذف الخدمة " + name + " ؟";
                    let text = "سوف يتم حذف هذه الخدمة نهائياً!";
                    confirmDelete(title, text).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteClinicServiceAction', clinicServiceId)
                        }
                    });
                }
            }
        }
    </script>
@endpush
