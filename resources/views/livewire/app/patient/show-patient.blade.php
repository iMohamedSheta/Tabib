@php
    use App\Enums\Helpers\HelperEnum;
    use App\Formatters\DateFormatter;
    use App\Formatters\AgeFormatter;
@endphp
<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    <x-main.head wire:ignore icon="{{ $patient->user->profile_photo_url }}">
        <x-slot name="title">
            المريض :
            {{ $patient->user->first_name . ' ' . $patient->user->last_name }}

        </x-slot>
        <x-slot name="body">
            <div class="text-gray-300 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium ">
                    رقم الهاتف :
                </dt>
                <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                    {{ $patient->user->phone }}
                </dd>
            </div>
            <div class="text-gray-300 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium ">
                    رقم الهاتف الاضافي :
                </dt>
                <dd class=" text-sm/6 sm:col-span-2 sm:mt-0">
                    {{ $patient->user->other_phone ?? HelperEnum::NOT_AVAILABLE->label() }}
                </dd>
            </div>
        </x-slot>
    </x-main.head>
    <div
        class="relative bg-purple-200 text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-xl">
        <x-tabs.tab-list selected-tab="medical_records">
            <x-slot name="tabs">
                <!-- Tab Heads -->
                <x-tabs.tab-head name="medical_records">
                    <i class="fa fa-file-medical"></i>
                    السجل الطبي
                </x-tabs.tab-head>
                <x-tabs.tab-head name="exams">
                    <i class="fa fa-stethoscope"></i>
                    الفحوصات
                </x-tabs.tab-head>
                <x-tabs.tab-head name="radiology">
                    <i class="fa fa-users"></i>
                    الاشعة
                </x-tabs.tab-head>
                <x-tabs.tab-head name="attached_files">
                    <i class="fa fa-folder"></i>
                    الملفات الملحقة
                </x-tabs.tab-head>
                <x-tabs.tab-head name="surgeries">
                    <i class="fa fa-user-md"></i>
                    العمليات
                </x-tabs.tab-head>
                <x-tabs.tab-head name="bills">
                    <i class="fa fa-file-invoice-dollar"></i>
                    الفواتير
                </x-tabs.tab-head>
                <x-tabs.tab-head name="appointments">
                    <i class="fa fa-calendar-check"></i>
                    الحجوزات
                </x-tabs.tab-head>
                <x-tabs.tab-head name="patient_note">
                    <i class="fa-solid fa-note-sticky"></i>
                    مذكرة المريض
                </x-tabs.tab-head>
            </x-slot>

            <!-- Tab Content -->
            <x-tabs.tab name="medical_records">
                <p class="px-4 py-8">
                    السجل الطبي للمريض يمكن من خلاله رؤية سجلات المريض الشخصية
                </p>
                <div class="flex flex-wrap">
                    <x-cells.cell label="الاسم" :border="false">
                        {{ $patient->user->first_name . ' ' . $patient->user->last_name }}
                    </x-cells.cell>
                    <x-cells.cell label="العنوان" :border="false">
                        {{ $patient->address }}
                    </x-cells.cell>
                    <x-cells.cell label="رقم التليفون">
                        {{ $patient->user->phone }}
                    </x-cells.cell>
                    <x-cells.cell label="رقم التليفون الاضافي">
                        {{ $patient->user->other_phone }}
                    </x-cells.cell>
                    <x-cells.cell label="اسم المستخدم">
                        {{ $patient->user->username }}
                    </x-cells.cell>
                    <x-cells.cell label="البريد الالكتروني">
                        {{ $patient->user->email }}
                    </x-cells.cell>
                    <x-cells.cell label="الرقم التعريفي للمريض">
                        <x-copy-clipboard>
                            {{ $patient->puid }}
                        </x-copy-clipboard>
                    </x-cells.cell>
                    <x-cells.cell label="العيادة المسجل فيها">
                        {{ $patient->clinic->name }}
                    </x-cells.cell>
                    <x-cells.cell label="العمر">
                        {{ AgeFormatter::ageView($patient->age) }}
                    </x-cells.cell>
                    <x-cells.cell label="تاريخ الميلاد">
                        {{ $patient->birth_date }}
                    </x-cells.cell>
                    <x-cells.cell label="الجنس">
                        {{ $patient->gender === 'female' ? 'انثي' : 'ذكر' }}
                    </x-cells.cell>
                    <x-cells.cell label="الجنسية">
                        {{ $patient->nationality }}
                    </x-cells.cell>
                    <x-cells.cell label="فصيلة الدم">
                        {{ $patient->blood_type }}
                    </x-cells.cell>
                    <x-cells.cell label="الرقم القومي">
                        {{ $patient->national_card_id }}
                    </x-cells.cell>
                    <x-cells.cell label="اخر اتصال">
                        <span class="text-green-900 flex items-center">
                            <i class="fa fa-circle text-[8px] text-green-700 px-2"></i>
                            {{ DateFormatter::human($patient->user->last_connect) }}
                        </span>
                    </x-cells.cell>
                    <x-cells.cell label="الطول">
                        {{ $patient->height }}
                    </x-cells.cell>
                    <x-cells.cell label="الحالة الاجتماعية">
                        {{ $patient->marital_status }}
                    </x-cells.cell>
                    <x-cells.cell label="العمل">
                        {{ $patient->height }}
                    </x-cells.cell>
                    <x-cells.cell label="مزود التأمين">
                        {{ $patient->marital_status }}
                    </x-cells.cell>
                    <x-cells.cell label="الرقم التأميني">
                        {{ $patient->marital_status }}
                    </x-cells.cell>
                    <x-cells.cell label="تاريخ الانشاء">
                        {{ DateFormatter::detailed($patient->created_at) }}
                    </x-cells.cell>
                    <x-cells.cell label="تاريخ اخر تعديل">
                        {{ DateFormatter::detailed($patient->updated_at) }}
                    </x-cells.cell>
                    <x-cells.cell label="الحساسية" :isText="true">
                        {{ $patient->allergies }}
                    </x-cells.cell>
                    <x-cells.cell label="امراض وراثية" :isText="true">
                        {{ $patient->family_medical_history }}
                    </x-cells.cell>
                    <x-cells.cell label="الامراض المزمنة" :isText="true">
                        {{ $patient->chronic_diseases }}
                    </x-cells.cell>
                </div>
            </x-tabs.tab>
            <x-tabs.tab name="exams">
                <p class="p-4">
                    هذه هي الفحوصات
                </p>
            </x-tabs.tab>
            <x-tabs.tab name="radiology">
                <p class="p-4">
                    هذه هي الأشعة
                </p>
            </x-tabs.tab>
            <x-tabs.tab name="attached_files">
                <p class="p-4">
                    {{-- @if ($patient->attached_files->isEmpty())
                        <p>لا توجد ملفات ملحقة.</p>
                    @else
                        <ul>
                            @foreach ($patient->attached_files as $file)
                                <li>
                                    <a href="{{ route('files.download', $file->id) }}"
                                        class="text-blue-500 hover:underline">
                                        {{ $file->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif --}}
                </p>
            </x-tabs.tab>
            <x-tabs.tab name="surgeries">
                <p class="p-4">
                    هذه هي العمليات
                </p>
            </x-tabs.tab>
            <x-tabs.tab name="bills">
                <p class="p-4">
                    هذه هي الفواتير
                </p>
            </x-tabs.tab>
            <x-tabs.tab name="appointments">
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
            </x-tabs.tab>
            <x-tabs.tab name="patient_note">
                <p class="px-4 py-8">
                    مذكرة المريض هي مكان يمكن فيه للطبيب أو المريض كتابة ملاحظات هامة تتعلق بالحالة الصحية للمريض، مثل
                    الأعراض، التشخيصات، التعليمات الطبية، أو أي معلومات أخرى قد تكون مفيدة لمتابعة العلاج.
                </p>
                <div class="flex flex-wrap">
                    <x-cells.cell label="مذكرة المريض" :isText="true" :border="false" minHeight="200px">
                        {{ $patient->notes }}
                    </x-cells.cell>
                </div>
            </x-tabs.tab>
        </x-tabs.tab-list>

    </div>

</div>
