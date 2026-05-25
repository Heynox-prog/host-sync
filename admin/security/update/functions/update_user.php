<?php
require_once "../../../database/includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : "";
    $new_role = isset($_POST["role"]) ? trim($_POST["role"]) : "";

    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$new_role, $user_id]);

    $success = "Utilisateur modifier avec succès";

    header("Location: ../../update/");
    exit;
}
?>