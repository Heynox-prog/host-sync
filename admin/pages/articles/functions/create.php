<?php
require_once "../../../database/includes/db.php";
session_start();

require "../../../functions/utilities.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["article_title"] ?? '';
    $description = $_POST["article_desc"] ?? '';
    $content = $_POST["article_content"] ?? '';
    $article_category = $_POST["article_category"] ?? '';
    $slug = slug($title);
    $author_name = $_SESSION["user_name"];

    if (strlen($title) < 10 || strlen($title) > 50) {
        $_SESSION["status-error"] = "Le titre doit contenir entre 10 et 50 caractères.";
        header("Location: ../create");
        exit;
    } elseif (strlen($description) < 10 || strlen($description) > 100) {
        $_SESSION["status-error"] = "La description doit contenir entre 10 et 100 caractères.";
        header("Location: ../create");
        exit;
    } elseif (strlen($content) < 200 || strlen($content) > 5000) {
        $_SESSION["status-error"] = "Le contenu doit contenir entre 200 et 5000 caractères.";
        header("Location: ../create");
        exit;
    } elseif ($article_category === "") {
        $_SESSION["status-error"] = "Vous devez sélectionner une catégorie !";
        header("Location: ../create");
        exit;
    } else {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE title = ?");
            $stmt->execute([$title]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $_SESSION["status-error"] = "Un article avec ce titre existe déjà.";
                header("Location: ../create");
                exit;
            } else {
                $stmt = $pdo->prepare("INSERT INTO articles (title, description, slug, content, category ,author_name) VALUES (?, ?, ?, ?, ? ,?)");
                $stmt->execute([$title, $description, $slug, $content, $article_category ,$author_name]);
                $_SESSION["status-success"] = "Un article a été créé !";

                header("Location: /articles/" . $slug);
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION["status-error"] = "Erreur lors de la création de l'article : " . $e->getMessage();
            header("Location: ../create");
            exit;
        }
    }
}
