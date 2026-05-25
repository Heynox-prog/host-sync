<?php
require_once "../../admin/database/includes/db.php";
session_start();

require "../../admin/functions/utilities.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']) ? true : false;

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if ($remember_me) {
                $plain_token = generateUniqueToken($pdo);
                $token = hash("sha256", $plain_token);
                $expiration = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30);
                $stmt = $pdo->prepare("INSERT INTO user_tokens (user_id, token, created_at, expires_at) VALUES (?, ?, NOW(), ?)");
                $stmt->execute([$user['id'], $token, $expiration]);
                
                setcookie(
                    'remember_me',
                    $plain_token,
                    [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'domain' => '',
                        'secure' => false,
                        'httponly' => true
                    ]
                );
            } else {
                $stmt = $pdo->prepare("DELETE FROM user_tokens WHERE user_id = ?");
                $stmt->execute([$user['id']]);
            }

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_firstname"] = $user["firstname"];
            $_SESSION["user_lastname"] = $user["lastname"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_created_at"] = $user["created_at"];
            $_SESSION["user_role"] = $user["role"];
            $_SESSION["id_client"] = $user["id_client"];

            if (empty($user["picture"])) {
                $_SESSION["user_picture"] = "/static/images/profile/default/default-profile.png";
            } else {
                $_SESSION["user_picture"] = $user["picture"];
            }

            header("Location: ../../dashboard/");
            exit;
        } else {
            $_SESSION["status-error"] = 'Email ou mot de passe incorrect !';
            header("Location: ../../user/connexion");
            exit;
        }
    } catch (PDOException $e) {
        echo '<div class="container">Une erreur de connexion: ' . $e->getMessage() . '</div>';
    }
}
?>