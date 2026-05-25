<?php
session_start();
require_once "../../database/includes/db.php";

$allowed_roles = ['administrateur', 'communication'];

if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_role'], $allowed_roles)) {
    header("Location: /");
    exit;
}

if (isset($_GET["slug"])) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ?");
    $stmt->execute([$_GET['slug']]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        header("Location: /admin/pages/articles");
        exit;
    }
} else {
    header("Location: /admin/pages/articles");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le contenu de l'article</title>

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../../static/js/themes/themes.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier le contenu de l'article</h1>
        <h2>Vous éditez l'article : <?= htmlspecialchars($article['title']) ?></h2>

        <form action="./functions/modify-function.php" method="POST">
            <input type="hidden" name="id" value="<?= $article['id'] ?>">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($article['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea name="content" id="content" required><?= htmlspecialchars($article['content']) ?></textarea>
            </div>
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>