@php
    use Carbon\Carbon;
    use App\Enums\Helpers\HelperEnum;
@endphp

<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    <x-main.head wire:ignore>
        <x-slot name="title">
            الاطباء
        </x-slot>
        <x-slot name="body">
            تتيح لك هذه الصفحة إدارة الأطباء الذين يعملون داخل العيادة، حيث يمكنك بسهولة إضافة أطباء جدد للنظام، تعديل
            بيانات الأطباء الحاليين، أو حذف الأطباء غير النشطين. لكل طبيب حساب خاص داخل النظام يمكّنه من متابعة مرضاه
            وملفاتهم الطبية بشكل فردي.
        </x-slot>
    </x-main.head>

    <div
        class="relative bg-purple-200 text-gray-700  dark:bg-c-gray-800 dark:text-white font-bold sm:px-6 py-6 rounded-lg shadow-xl">
        <div>
            <div class="flex justify-between mb-2">
                <livewire:app.doctor.includes.create-doctor-modal
                    :clinics="$clinics"></livewire:app.doctor.includes.create-doctor-modal>
            </div>
            <div
                class=" md:flex md:flex-wrap justify-center mx-2  border border-gray-600 border-dashed rounded-lg bg-c-gray-700 ">
                @forelse ($doctors as $doctor)
                    <div class="p-2  md:w-1/4 mx-auto  ">
                        <div class="my-6 bg-purple-700 rounded-xl">

                            <div
                                class="max-w-md mx-auto min-w-0 break-words bg-purple-100 w-full shadow-lg rounded-xl transform transition-transform duration-300 hover:-translate-x-2 hover:-translate-y-2  hover:shadow-2xl">
                                <div class="px-6">
                                    <div class="flex flex-wrap justify-center">
                                        <div class="w-full flex justify-center">
                                            <div class="relative">
                                                <img src="{{ $doctor->profile_photo_url }}"
                                                    class="mx-auto  mt-4 mr-4 w-40 h-40 rounded-full object-cover">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <h3 class="text-xl text-slate-700 font-bold leading-normal pb-2">
                                            دكتور/
                                            {{ $doctor->fullname }}
                                        </h3>
                                        <div class="text-xs mt-0 mb-2 text-slate-400 font-bold uppercase">
                                            <i
                                                class="fas fa-map-marker-alt mr-2 text-slate-400 opacity-75 px-1 pb-2"></i>{{ $doctor->organization_name }}
                                            <p class="font-light leading-relaxed text-slate-600 mb-4">
                                                {{ $doctor->specialization }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 py-6 border-t border-gray-400 text-center">
                                        <div class="flex flex-wrap justify-center">
                                            <div class="w-full px-4">
                                                <p class="font-light leading-relaxed text-slate-600 mb-2">
                                                    {{ $doctor->phone }}</p>
                                                <p class="font-light leading-relaxed text-slate-600 mb-4">
                                                    {{ $doctor->other_phone ?: HelperEnum::NOT_AVAILABLE->label() }}</p>

                                                <x-datatable.tdata.actions name="العمليات" :isTable="false">
                                                    <div x-data="updateModal" x-on:updated.window="show = false">
                                                        <x-datatable.tdata.link href="#" @click="show = true">
                                                            <i class="fa-solid fa-pencil fa-lg px-2"></i>
                                                            تعديل
                                                        </x-datatable.tdata.link>
                                                        @teleport('body')
                                                            <div class="text-right">
                                                                <livewire:app.doctor.includes.update-doctor-modal
                                                                    :key="now() . random_int(1, 999999)" :doctor="$doctor" :clinics="$clinics">
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
                                                                <livewire:app.doctor.includes.info-doctor-modal
                                                                    :key="now() . random_int(1, 999999)" :doctor="$doctor" :clinics="$clinics">
                                                                </livewire:app.doctor.includes.info-doctor-modal>
                                                            </div>
                                                        @endteleport
                                                    </div>

                                                    <div x-data="deleteData">
                                                        <x-datatable.tdata.link href="#"
                                                            x-on:click="confirmedDelete('{{ $doctor->fullname }}', '{{ $doctor->doctor_id }}')"
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
                @empty
                    <x-datatable.tempty></x-datatable.tempty>
                @endforelse
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
