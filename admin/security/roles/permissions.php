<?php

function has_permission(string $permission): bool {

    if (!isset($_SESSION['user_role'])) {
        return false;
    }

    $roles = require __DIR__ . '/index.php';
    $user_role = $_SESSION['user_role'];

    if (!isset($roles[$user_role])) {
        return false;
    }

    return in_array($permission, $roles[$user_role]);
}
