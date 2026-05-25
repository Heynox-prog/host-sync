<?php
require_once "../admin/database/includes/db.php";
session_start();

$error = "";

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    $error = "Aucun article trouvé avec ce nom !";
    exit;
}

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ?");
$stmt->execute([$slug]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

$theme = $_COOKIE["theme"] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title'] ?? '') ?></title>
    <link rel="stylesheet" href="../static/css/layout/main.css">
    <link rel="stylesheet" href="../static/css/layout/themes.css">
    <link rel="stylesheet" href="../static/css/layout/header.css">
    <link rel="stylesheet" href="../static/css/pages/view-article.css">
    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../static/js/themes/themes.js" defer></script>
    <script src="../static/js/layout/header.js" defer></script>
    <script src="../static/js/layout/dialog.js" defer></script>
    <script src="../static/js/pages/articles.js" defer></script>
</head>
<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../admin/layout/interface/header.php"; ?>

    <div class="article-container">
        <div class="article-header">
            <div class="article-image">
                <img src="../static/images/article/default/default-img.jpg" alt="<?= htmlspecialchars($article['title'] ?? '') ?>" class="article-img">
            </div>
            <div class="article-tag">
                <p class="article-italic">
                    .<?= htmlspecialchars(strtoupper($article['category'] ?? '')) ?>
                </p>
            </div>
            <div class="article-title">
                <h1>
                    <?= htmlspecialchars($article['title'] ?? '') ?>
                </h1>
            </div>
            <div class="article-infos">
                <p>
                    Auteur <span class="author-tag">| <?= htmlspecialchars($article['author_name'] ?? '') ?></span>
                </p>
                <p>
                    POSTÉ LE <?= htmlspecialchars(date('d/m/Y', strtotime($article['created_at'] ?? ''))) ?>
                </p>
            </div>
            <div class="article-divider"></div>
        </div>
        <div class="article-body">
            <p>
                <?= $article["content"] ?>
            </p>
        </div>
    </div>
</body>
</html>
