<?php

return [
    'permissions' => [
        'create_presensi_record',
        'create_presensi',
        'create_pengumuman',
        'create_kelas',
        'create_course',
        'create_user'
    ],
    'roles' => [
        'student' => 'student',
        'teacher' => 'teacher',
        'bk' => 'bk',
        'super_admin' => 'super_admin',
    ],
    'opening_status' => [
        'registered' => 1,
        'activated' => 2,
        'suspended' => 3,
    ]
];
