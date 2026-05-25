<?php

function getAuth(PDO $pdo) {
    if (!isset($_SESSION["user_id"])) {
        header("Location: /user/connexion");
        exit();
    } else {
        $stmt = $pdo->prepare("SELECT verified FROM users WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user["verified"] == 1) {
            return true;
        } else {
            $_SESSION["status-not-verified"] = "Veuillez vérifier votre adresse e-mail pour accéder à votre compte.";
            header("Location: /user/connexion");
            exit();
        }
    }
}

function getCookieSession(PDO $pdo) {
    if (!isset($_SESSION["user_id"]) && isset($_COOKIE["remember_me"])) {
        $plain_token = $_COOKIE["remember_me"];
        $token = hash("sha256", $plain_token);

        $stmt = $pdo->prepare("SELECT * FROM user_tokens WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_info) {
            $_SESSION["user_id"] = $user_info["id"];
            $_SESSION["user_firstname"] = $user_info["firstname"];
            $_SESSION["user_lastname"] = $user_info["lastname"];
            $_SESSION["user_email"] = $user_info["email"];
            $_SESSION["user_created_at"] = $user_info["created_at"];
            $_SESSION["user_role"] = $user_info["role"];
            $_SESSION["id_client"] = $user_info["id_client"];

            $new_token = hash("sha256", generateUniqueToken($pdo));
            $expiration = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30);
            
            $stmt = $pdo->prepare("UPDATE user_tokens SET token = ?, created_at = NOW(), expires_at = ? WHERE user_id = ? AND token = ?");
            $stmt->execute([$new_token, $expiration, $_SESSION["user_id"], $token]);
            
            setcookie(
                'remember_me',
                $new_token,
                [
                    'expires' => time() + 60 * 60 * 24 * 30,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => true
                ]
            );
        }
    }
}