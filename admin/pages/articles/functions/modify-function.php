<?php
session_start();
require_once "../../../database/includes/db.php";

if (!isset($_SESSION["token"]) || $_SESSION['user_role'] !== 'administrateur') {
    header("Location: /");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title) || empty($content)) {
        $error = "Tous les champs sont requis.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE title = ?");
            $stmt->execute([$title]);
            $acticlesCount = $stmt->fetchColumn();

            if ($acticlesCount > 0) {
                $error = "Un article avec ce titre existe déjà.";
            } else {
                $stmt = $pdo->prepare("UPDATE articles SET title = ?, content = ? WHERE id = ?");
                $stmt->execute([$title, $content, $_POST['id']]);
                $success = "L'article a été modifié avec succès !";

                header("Location: /articles/" . strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $title), '-')));
                exit;
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la modification de l'article : " . $e->getMessage();
        }
    }
}