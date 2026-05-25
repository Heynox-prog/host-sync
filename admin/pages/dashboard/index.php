<?php
require_once "../../database/includes/db.php";
session_start();

require "../../functions/utilities.php";

$theme = $_COOKIE["theme"] ?? "light";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>

    <link rel="stylesheet" href="../../../static/css/layout/main.css">
    <link rel="stylesheet" href="../../../static/css/layout/themes.css">
    <link rel="stylesheet" href="../../../static/css/layout/header.css">
    <link rel="stylesheet" href="../../static/css/dashboard.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../../static/js/themes/themes.js" defer></script>
    <script src="../../../static/js/layout/header.js" defer></script>

    <style>
        .wrapper {
            width: 100%;
            overflow-x: scroll;
            margin: 2rem 0;
        }
        .wrapper::-webkit-scrollbar {
            height: 4px;
        }
        .wrapper::-webkit-scrollbar-thumb {
            background: var(--theme-primary);
            border-radius: 4px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-collapse: collapse;
            width: 100%;
        }

        .grid-header {
            background-color: var(--theme-secondary);
            border-color: var(--theme-primary);
        }

        .grid-header,
        .grid-item {
            padding: 1rem;
            border: 1px solid var(--theme-secondary);
            min-width: 130px;
        }

        @media (max-width: 490px) {
            .grid-header, .grid-item { width: 65vw; }
        }
    </style>
</head>

<body data-theme="<?= htmlspecialchars($_COOKIE["theme"] ?? "light") ?>">
    <?php require_once "../../layout/interface/header.php"; ?>

    <main class="main-container">
        <div class="titles">
            <h1 class="main-title">Tableau de bord administrateur</h1>
            <h2 class="subtitle"></h2>
        </div>
    </main>

    <section class="section-container">
        <div class="wrapper">
            <div class="grid-container">
                <div class="grid-header">Titre</div>
                <div class="grid-header">Description</div>
                <div class="grid-header">Date</div>
                <div class="grid-header">Dernière modification</div>
                <div class="grid-header">Slug</div>
                <div class="grid-header">Auteur</div>
                <div class="grid-header">Actions</div>

                <?php if ($articles = getArticlesCount($pdo)): ?>
                    <?php foreach (getArticlesLimit($pdo) as $article): ?>
                        <div class="grid-item"><?= htmlspecialchars($article['title']) ?></div>
                        <div class="grid-item"><?= htmlspecialchars($article['description']) ?></div>
                        <div class="grid-item"><?= date('d/m/Y', strtotime($article['created_at'])) ?></div>
                        <div class="grid-item"><?= date('d/m/Y', strtotime($article['updated_at'])) ?></div>
                        <div class="grid-item"><?= htmlspecialchars($article['slug']) ?></div>
                        <div class="grid-item"><?= htmlspecialchars($article['author_name']) ?></div>
                        <div class="grid-item">
                            <a href="/admin/pages/articles/edit-article.php?slug=<?= $article['slug'] ?>">Modifier</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="grid-item">
                        <h2 class="grid-title">Aucun article trouvé.</h2>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>