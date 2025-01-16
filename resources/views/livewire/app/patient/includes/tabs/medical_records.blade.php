@php
    use App\Formatters\DateFormatter;
    use App\Formatters\AgeFormatter;
@endphp
<div>
    <p class="px-4 pb-6">
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
</div>
