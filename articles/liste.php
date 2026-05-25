<?php
require_once "../admin/database/includes/db.php";
session_start();

$theme = $_COOKIE['theme'] ?? 'light';

$sort = $_GET['sort'] ?? 'default';

switch ($sort) {
    case 'old':
        $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at ASC LIMIT 5");
        break;
    case 'patch-note':
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE category = 'patch-note' ORDER BY created_at DESC LIMIT 5");
        $stmt->execute();
        break;
    case 'actualite':
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE category = 'actualite' ORDER BY created_at DESC LIMIT 5");
        $stmt->execute();
        break;
    case 'new':
    case 'default':
    default:
        $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 5");
        break;
}

if (!isset($articles)) {
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos articles</title>
    <link rel="stylesheet" href="../static/css/layout/main.css">
    <link rel="stylesheet" href="../static/css/layout/themes.css">
    <link rel="stylesheet" href="../static/css/layout/header.css">
    <link rel="stylesheet" href="../static/css/pages/articles.css">
    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../static/js/themes/themes.js" defer></script>
    <script src="../static/js/layout/header.js" defer></script>
    <script src="../static/js/layout/dialog.js" defer></script>
    <script src="../static/js/pages/articles.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../admin/layout/interface/header.php"; ?>

    <main class="main-container">
        <div class="articles-header">
            <div class="titles">
                <h1>Nos articles</h1>
                <h2>Découvrez toute l'actualité de host-sync.</h2>
            </div>
            <div class="sort-articles">
                <button class="sort-articles__toggler">
                    Choisissez le type de tri
                </button>
                <div class="sort-articles__type">
                    <button class="sort-articles__type_choice <?= $sort === 'default' || $sort === 'new' ? 'active' : '' ?>" data-sort="default">Dernière sortie</button>
                    <button class="sort-articles__type_choice <?= $sort === 'old' ? 'active' : '' ?>" data-sort="old">Première sortie</button>
                    <button class="sort-articles__type_choice <?= $sort === 'patch-note' ? 'active' : '' ?>" data-sort="patch-note">Patch notes</button>
                    <button class="sort-articles__type_choice <?= $sort === 'actualite' ? 'active' : '' ?>" data-sort="actualite">Actualités</button>
                </div>
            </div>
        </div>

        <div class="articles-list">
            <?php foreach ($articles as $article): ?>
                <div class="article-container">
                    <a href="/articles/<?= htmlspecialchars($article['slug']) ?>" class="article">
                        <div class="article-items">
                            <div class="article-row1">
                                <img src="../static/images/article/default/default-img.jpg" alt="<?= htmlspecialchars($article['title']) ?>" class="article-image">
                            </div>
                            <div class="article-row2">
                                <h3 class="article-title">
                                    <?= htmlspecialchars($article["title"]) ?>
                                </h3>
                            </div>
                            <div class="article-row3">
                                <div class="article-date">
                                    <?= htmlspecialchars(date('d/m/Y', strtotime($article["created_at"]))) ?>
                                </div>
                                <div class="article-author">
                                    <?= htmlspecialchars($article["author_name"]) ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "administrateur"): ?>
                        <div class="admin-commands">
                            <button class="remove-btn" type="submit" onclick="dialog('open')">Supprimer</button>
                            <form action="../admin/pages/articles/edit-article.php?slug=<?= htmlspecialchars($article["slug"]) ?>" method="post">
                                <button class="update-btn" type="submit">Éditer</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($_SESSION["status-error"])): ?>
        <div class="status">
          <p class="status-error">
            <?= htmlspecialchars($_SESSION["status-error"]) ?>

            <?php unset($_SESSION["status-error"]); ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION["status-success"])): ?>
        <div class="status">
          <p class="status-success">
            <?= htmlspecialchars($_SESSION["status-success"]) ?>

            <?php unset($_SESSION["status-success"]); ?>
          </p>
        </div>
      <?php endif; ?>
    </main>

    <?php require "../admin/layout/interface/dialog-box.php" ?>
</body>

</html>