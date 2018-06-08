<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Admin ui',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'userGroup',
    ],
    'superAdmin' => [
        'type' => 1,
        'description' => 'Super Admin',
        'ruleName' => 'userGroup',
    ],
    'staff' => [
        'type' => 1,
        'description' => 'Staff',
        'ruleName' => 'userGroup',
    ],
    'relative' => [
        'type' => 1,
        'description' => 'Relative',
        'ruleName' => 'userGroup',
    ],
    'patient' => [
        'type' => 1,
        'description' => 'Patient',
        'ruleName' => 'userGroup',
    ],
];
