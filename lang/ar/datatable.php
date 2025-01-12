<?php

return [
    'clinic_table' => [
        'name' => 'اسم العيادة',
        'specialization' => 'النوع',
        'clinic' => 'كود التحصيل',
        'plan' => 'الخطة',
        'created_at' => 'تاريخ الانشاء',
    ],
    'patient_table' => [
        'name' => 'اسم المريض',
        'puid' => 'الرقم التعريفي للمريض',
        'clinic' => 'العيادة',
        'phone' => 'رقم الهاتف',
        'created_at' => 'تاريخ الانشاء',
    ],
    'clinic_services_table' => [
        'name' => 'اسم الخدمة',
        'clinic' => 'العيادة',
        'price' => 'السعر',
        'color' => 'اللون المميز',
        'patients' => 'عدد المرضى',
        'created_at' => 'تاريخ الانشاء',
    ],
];
