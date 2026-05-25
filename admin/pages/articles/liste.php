<?php
require_once "../../database/includes/db.php";
session_start();

$allowed_roles = ['administrateur', 'communication'];

if (!isset($_SESSION["token"]) || !in_array($_SESSION['user_role'], $allowed_roles)) {
    header("Location: /");
    exit;
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM articles");
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = '';

if ($articles < 1) {
    $error = "Aucun article trouvé avec cet ID.";
} else {
    $stmt = $pdo->prepare("SELECT * FROM articles");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification des articles</title>

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../../static/js/themes/themes.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier un article</h1>

        <?php foreach ($articles as $article): ?>
            <div class="article-item">
                <h2><?= htmlspecialchars($article['title']) ?></h2>
                <p><?= htmlspecialchars($article['content']) ?></p>
                <small>Publié par <?= htmlspecialchars($article['author_name']) ?> le <?= date('d/m/Y', strtotime($article['created_at'])) ?></small>
                <a href="/admin/pages/articles/edit-article.php?slug=<?= $article['slug'] ?>">Modifier</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>