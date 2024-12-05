<?php
$allPermissions = [
    'super user',
    'manage users',
    'manage financials',
    'developer',
];
$allRoles = [
    'admin',
    'organisation',
    'service',
];
$developerPermissions = [
    'developer',
    'manage users',
    'manage financials',
];
$developerRoles = [
    'developer',
];
$adminPermissions = [
    'manage users',
    'manage financials',
];
$adminRoles = [
    'admin',
];
$organisationPermissions = [
    'manage users',
    'manage financials',
];
$organisationRoles = [
    'organisation',
];

return [
    'permissions' => [
        'all' => $allPermissions,
        'developer' => $developerPermissions,
        'admin' => $adminPermissions,
        'organisation' => $organisationPermissions,
    ],

    'roles' => [
        'all' => $allRoles,
        'developer' => $developerRoles,
        'admin' => $adminRoles,
        'organisation' => $organisationRoles,
    ]
];
