<?php
require_once "../../../database/includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = isset($_POST["user_id"]) ? trim($_POST["user_id"]) : "";

    if (!empty($user_id)) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        header("Location: ../../update/");
        exit;
    }
}
?>