<?php
return [
    'Pasien & Dokter' => [
        'icon' => 'fa-user-md',
        'items' => [
            ['label' => 'Patients',        'controller' => 'Patients',      'action' => 'index', 'prefix' => 'Registrasi'],
            ['label' => 'Doctor',          'controller' => 'Doctors',       'action' => 'index', 'prefix' => 'Master'],
            ['label' => 'Doctor Schedules','controller' => 'DoctorSchedules','action' => 'index','prefix' => 'Master'],
        ],
    ],
    'Fasilitas' => [
        'icon' => 'fa-hospital-o',
        'items' => [
            ['label' => 'Polyclinics', 'controller' => 'Polyclinics', 'action' => 'index', 'prefix' => 'Registrasi'],
            ['label' => 'Rooms',       'controller' => 'Rooms',       'action' => 'index', 'prefix' => 'Master'],
        ],
    ],
    // ...grup lainnya
];