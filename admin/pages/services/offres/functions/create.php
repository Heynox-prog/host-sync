<?php
require_once "../../../../database/includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $service_id = $_POST["service_id"] ?? '';

    if (strlen($name) < 10) {
        $_SESSION["status-error"] = "Votre titre doit contenir au minimum 10 caractères !";
        header("Location: ../");
        exit;
    }

    if (strlen($description) < 5 || strlen($description) > 100) {
        $_SESSION["status-error"] = "Votre description doit se situer entre 5 et 100 caractères !";
        header("Location: ../");
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../../../../../static/images/offres/";
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $tmpName);

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION["status-error"] = "Format d'image non autorisé.";
            header("Location: ../");
            exit;
        }

        $uniqueName = uniqid() . '-' . $originalName;
        $destination = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $destination)) {
            try {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM offers WHERE name = ?");
                $stmt->execute([$name]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    $_SESSION["status-error"] = "Une offre avec le même nom existe déjà !";
                    header("Location: ../");
                    exit;
                } else {
                    $stmt = $pdo->prepare("INSERT INTO offers (name, description, service_id, image_path) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $description, $service_id, $destination]);

                    $_SESSION["status-success"] = "Offre ajoutée avec succès !";
                    header("Location: ../");
                    exit;
                }
            } catch (PDOException $e) {
                $_SESSION["status-error"] = "Une erreur est survenue : " . $e->getMessage();
                header("Location: ../");
                exit;
            }
        } else {
            $_SESSION["status-error"] = "Erreur lors du déplacement de l'image.";
            header("Location: ../");
            exit;
        }
    } else {
        $_SESSION["status-error"] = "Aucune image reçue.";
        header("Location: ../");
        exit;
    }
}

?>