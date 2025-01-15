<?php

return [
    'view' =>
    [
        'show-patient' =>
        [
            'tabs' =>
            [
                'medical_records' => [
                    'icon' => 'fa fa-file-medical',
                    'file' => 'livewire.app.patient.includes.tabs.medical_records',
                    'trans_key' =>  'السجل الطبي'
                ],
                'exams' => [
                    'icon' => 'fa fa-stethoscope',
                    'file' => 'livewire.app.patient.includes.tabs.exams',
                    'trans_key' =>  'الفحوصات'
                ],
                'radiology' => [
                    'icon' => 'fa fa-users',
                    'file' => 'livewire.app.patient.includes.tabs.radiology',
                    'trans_key' => 'الاشعة'
                ],
                'attached_files' => [
                    'icon' => 'fa fa-folder',
                    'file' => 'livewire.app.patient.includes.tabs.attached_files',
                    'trans_key' =>  'الملفات الملحقة'
                ],
                'surgeries' => [
                    'icon' => 'fa fa-user-md',
                    'file' => 'livewire.app.patient.includes.tabs.surgeries',
                    'trans_key' =>  'العمليات'
                ],
                'bills' => [
                    'icon' => 'fa fa-file-invoice-dollar',
                    'file' => 'livewire.app.patient.includes.tabs.bills',
                    'trans_key' =>  'الفواتير'
                ],
                'appointments' => [
                    'icon' => 'fa fa-calendar-check',
                    'file' => 'livewire.app.patient.includes.tabs.appointments',
                    'trans_key' =>  'الحجوزات'
                ],
                'patient_note' => [
                    'icon' => 'fa fa-note-sticky',
                    'file' => 'livewire.app.patient.includes.tabs.patient_note',
                    'trans_key' =>  'مذكرة المريض'
                ],
            ]
        ]
    ]
];
