<?php
session_start();
require_once "../../database/includes/db.php";

$allowed_roles = ['administrateur', 'communication'];

if (!isset($_SESSION["token"]) || !in_array($_SESSION['user_role'], $allowed_roles)) {
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

$stmt = $pdo->prepare("DELETE FROM articles WHERE slug = ?");
$stmt->execute([$_GET['slug']]);
$articles = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION["status-success"] = "L'article a été supprimé avec succès !";
header("Location: /articles/liste");
?>