<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../admin/database/includes/db.php";
session_start();

$error = "";

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    $error = "Aucun service trouvé avec ce nom !";
    exit;
}

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ?");
$stmt->execute([$slug]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

$theme = $_COOKIE["theme"] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($service['title'] ?? '') ?></title>
    <link rel="stylesheet" href="../static/css/layout/main.css">
    <link rel="stylesheet" href="../static/css/layout/themes.css">
    <link rel="stylesheet" href="../static/css/layout/header.css">
    <link rel="stylesheet" href="../static/css/layout/footer.css">
    <link rel="stylesheet" href="../static/css/pages/view-service.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../static/js/themes/themes.js" defer></script>
    <script src="../static/js/layout/header.js" defer></script>
    <script src="../static/js/layout/dialog.js" defer></script>
</head>
<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../admin/layout/interface/header.php"; ?>

    <main class="main-container">
        <div class="service-header">
            <div class="service-image">
                <img src="<?= htmlspecialchars($service['image_path'] ?? '') ?>" alt="<?= htmlspecialchars($service['title'] ?? '') ?>" class="service-img">
            </div>
            <div class="service-title">
                <h1>
                    <?= htmlspecialchars($service['title'] ?? '') ?>
                </h1>
            </div>
            <div class="service-infos">
                <p>
                    Auteur <span class="author-tag">| <?= htmlspecialchars($service['author_name'] ?? 'Pas d\'auteur spécifié') ?></span>
                </p>
                <p>
                    POSTÉ LE <?= htmlspecialchars(date('d/m/Y', strtotime($service['created_at'] ?? ''))) ?>
                </p>
            </div>
            <div class="service-divider"></div>
        </div>
        <div class="service-body">
            <p>
                <?= $service["long_description"] ?>
            </p>
        </div>
    </main>

    <?php require "../admin/layout/interface/footer.php"; ?>
</body>
</html>
