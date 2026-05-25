<?php
session_start();

return [
    'administrateur' => [
        'manage_users',
        'manage_roles',
        'view_dashboard',
        'edit_content',
        'create_content',
        'delete_content',
        'view_content'
    ],
    'modérateur' => [],
    'communication' => [
        'edit_content',
        'create_content',
        'delete_content',
        'view_content'
    ],
    'vip' => [],
    'utilisateur' => [],
];