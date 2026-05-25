<?php
require "./admin/database/includes/db.php";
session_start();

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verified_token = ? AND verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET verified = 1 WHERE verified_token = ?");
        $stmt->execute([$token]);

        $_SESSION["status-success"] = "Votre compte a été activé avec succès !";
    } else {
        $_SESSION["status-error"] = "Ce lien d'activation est invalide ou votre compte est déjà activé.";
    }
} else {
    $_SESSION["status-error"] = "Aucun e-mail fourni.";
}

header("Location: ../../user/connexion");
exit;
?>