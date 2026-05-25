<?php
require_once "../../admin/database/includes/db.php";
session_start();

require "../../admin/functions/utilities.php";
require "../../admin/functions/auth.php";

getAuth($pdo);

$_COOKIE['theme'] = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Légal | CGU</title>

    <link rel="stylesheet" href="../../static/css/layout/main.css">
    <link rel="stylesheet" href="../../static/css/layout/themes.css">
    <link rel="stylesheet" href="../../static/css/layout/header.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../static/js/themes/themes.js" defer></script>
    <script src="../../static/js/layout/header.js" defer></script>

    <link rel="stylesheet" href="../../static/css/pages/developement.css">
</head>
<body data-theme="<?= htmlspecialchars($_COOKIE['theme']) ?>">
    <?php require "../../admin/layout/interface/header.php"; ?>
    <?php require "../../in-developement/index.php"; ?>
</body>
</html>