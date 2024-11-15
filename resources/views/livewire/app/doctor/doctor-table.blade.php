@php
    use Carbon\Carbon;
@endphp

<div class="md:container py-6 mx-auto grid my-6 text-gray-700 dark:text-gray-200"  >
    <x-main.head wire:ignore >
        <x-slot name="title">
            الاطباء
        </x-slot>
        <x-slot name="body">
            تتيح لك هذه الصفحة إدارة الأطباء الذين يعملون داخل العيادة، حيث يمكنك بسهولة إضافة أطباء جدد للنظام، تعديل بيانات الأطباء الحاليين، أو حذف الأطباء غير النشطين. لكل طبيب حساب خاص داخل النظام يمكّنه من متابعة مرضاه وملفاتهم الطبية بشكل فردي.
        </x-slot>
    </x-main.head>

    <div class="relative bg-purple-200 text-gray-700  dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <div>
    {{-- <x-datatable.table :total="$doctors->total()">
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
                    <x-datatable.tdata.actions :name="$doctor->username">
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
                        <div x-data="infoModal" x-on:updated="show = false">
                            <x-datatable.tdata.link href="#" @click="show = true">
                                <i class="fa-solid fa-database fa-lg px-2"></i>
                                تفاصيل
                            </x-datatable.tdata.link>
                            <div class="text-right">
                                <livewire:app.doctor.includes.info-doctor-modal :key="now() . random_int(1, 999999)" :doctor="$doctor"
                                    :clinics="$clinics">
                                </livewire:app.doctor.includes.info-doctor-modal>
                            </div>
                        </div>

                        <div x-data="deleteData">
                            <x-datatable.tdata.link href="#"
                                x-on:click="confirmedDelete('{{ $doctor->fullname }}', '{{ $doctor->id }}')"
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
                        {{ $doctor->clinic_name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $doctor->phone }}
                    </td>
                    <td class="px-4 py-3" dir="ltr">
                        {{ Carbon::parse($doctor->created_at)->format('d/m/Y - h:ia ') }}
                    </td>
                </x-datatable.trow>
            @endforeach
        </x-datatable.tbody>

    </x-datatable.table>

    <x-datatable.pagination :paginator="$doctors"></x-datatable.pagination> --}}

    <div class="flex justify-between mb-2">
        <livewire:app.doctor.includes.create-doctor-modal :clinics="$clinics"></livewire:app.doctor.includes.create-doctor-modal>
    </div>
    <div class=" md:flex md:flex-wrap mx-2 ">
        @foreach ($doctors as $doctor)
            <div class="m-2  md:w-1/4  ">
                <div class="my-6 bg-purple-700 rounded-xl">

                <div class="max-w-md mx-auto min-w-0 break-words bg-purple-100 w-full shadow-lg rounded-xl transform transition-transform duration-300 hover:-translate-x-2 hover:-translate-y-2  hover:shadow-2xl">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full flex justify-center">
                                <div class="relative">
                                    <img src="{{ $doctor->profile_photo_url }}" class="mx-auto  mt-4 mr-4 w-40 h-40 rounded-full object-cover">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <h3 class="text-2xl text-slate-700 font-bold leading-normal mb-1">{{ $doctor->fullname }}</h3>
                            <div class="text-xs mt-0 mb-2 text-slate-400 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-slate-400 opacity-75 px-1 pb-2"></i>{{ $doctor->clinic_name }}
                                <p class="font-light leading-relaxed text-slate-600 mb-4">{{ $doctor->specialization }}</p>
                            </div>
                        </div>
                        <div class="mt-6 py-6 border-t border-gray-400 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full px-4">
                                    <p class="font-light leading-relaxed text-slate-600 mb-2">{{ $doctor->phone }}</p>
                                    <p class="font-light leading-relaxed text-slate-600 mb-4">{{ $doctor->other_phone ?: "N/A" }}</p>

                                    <x-datatable.tdata.actions name="العمليات" :isTable="false">
                                        <div x-data="updateModal" x-on:updated.window="show = false">
                                            <x-datatable.tdata.link href="#" @click="show = true">
                                                <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                                تعديل
                                            </x-datatable.tdata.link>
                                            @teleport('body')
                                            <div class="text-right">
                                                <livewire:app.doctor.includes.update-doctor-modal :key="now() . random_int(1, 999999)" :doctor="$doctor"
                                                    :clinics="$clinics">
                                                </livewire:app.doctor.includes.update-doctor-modal>
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
                                                <livewire:app.doctor.includes.info-doctor-modal :key="now() . random_int(1, 999999)" :doctor="$doctor"
                                                    :clinics="$clinics">
                                                </livewire:app.doctor.includes.info-doctor-modal>
                                            </div>
                                            @endteleport
                                        </div>

                                        <div x-data="deleteData">
                                            <x-datatable.tdata.link href="#"
                                                x-on:click="confirmedDelete('{{ $doctor->fullname }}', '{{ $doctor->id }}')"
                                                class="bg-red-500 hover:bg-red-600 dark:hover:bg-red-600  text-white hover:text-white">
                                                <i class="fa-solid fa-trash fa-lg px-2"></i>
                                                حذف
                                            </x-datatable.tdata.link>
                                        </div>
                                    </x-datatable.tdata.actions>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-datatable.pagination :paginator="$doctors"></x-datatable.pagination>
</div>
    </div>
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
