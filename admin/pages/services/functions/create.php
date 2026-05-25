<?php
require_once "../../../database/includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"] ?? '';
    $slug = slug($title);
    $short_description = $_POST["short_description"] ?? '';
    $long_description = $_POST["long_description"] ?? '';

    if (strlen($title) < 10) {
        $_SESSION["status-error"] = "Votre titre doit contenir au minimum 10 caractères !";
        header("Location: ../create");
        exit;
    }

    if (strlen($short_description) < 35 || strlen($short_description) > 50) {
        $_SESSION["status-error"] = "Votre description courte doit se situer entre 35 et 50 caractères !";
        header("Location: ../create");
        exit;
    }

    if (strlen($long_description) < 200 || strlen($long_description) > 500) {
        $_SESSION["status-error"] = "Votre description longue doit se situer entre 200 et 500 caractères !";
        header("Location: ../create");
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../../../../static/images/services/";
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $tmpName);

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION["status-error"] = "Format d'image non autorisé.";
            header("Location: ../create");
            exit;
        }

        $uniqueName = uniqid() . '-' . $originalName;
        $destination = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $destination)) {
            try {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE title = ?");
                $stmt->execute([$title]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    $_SESSION["status-error"] = "Un service avec le même titre existe déjà !";
                    header("Location: ../create");
                    exit;
                } else {
                    $stmt = $pdo->prepare("INSERT INTO services (title, slug, short_description, long_description, image_path) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $slug, $short_description, $long_description, $destination]);

                    $_SESSION["status-success"] = "Service ajouté avec succès !";
                    header("Location: ../create");
                    exit;
                }
            } catch (PDOException $e) {
                $_SESSION["status-error"] = "Une erreur est survenue : " . $e->getMessage();
                header("Location: ../create");
                exit;
            }
        } else {
            $_SESSION["status-error"] = "Erreur lors du déplacement de l'image.";
            header("Location: ../create");
            exit;
        }
    } else {
        $_SESSION["status-error"] = "Aucune image reçue.";
        header("Location: ../create");
        exit;
    }
}

?>