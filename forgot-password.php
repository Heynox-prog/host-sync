<?php
require_once "../admin/database/includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!empty($email)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $plain_token = bin2hex(random_bytes(32));
            $token = hash("sha256", $plain_token);
            $expiration = date('Y-m-d H:i:s', time() + 60 * 60);
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$email, $token, $expiration]);

            $reset_link = "http://dev-studio.host-sync.com/reset-password.php?token=" . $token;
            mail($email, "Réinitialisation de mot de passe", "Cliquez sur ce lien pour réinitialiser votre mot de passe : " . $reset_link);

            $_SESSION["status-success"] = "Un email de réinitialisation a été envoyé.";
        } else {
            $_SESSION["status-error"] = "Aucun utilisateur trouvé avec cet email.";
        }
    } else {
        $_SESSION["status-error"] = "Veuillez entrer votre email.";
    }
}

$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié ?</title>

    <link rel="stylesheet" href="./static/css/layout/theme.css">
    <link rel="stylesheet" href="./static/css/layout/main.css">
    <link rel="stylesheet" href="./static/css/page/forgot-password.css">

    <script src="./static/js/themes/themes.js" defer></script>
</head>
<body data-theme="<?= htmlspecialchars($theme) ?>">
    <main class="main-container">
        <div class="wrapper">
            <div class="wrapper-header">
                <div class="title">
                <h1>Mot de passe oublié ?</h1>
            </div>
            <div class="description">
                <p>
                    Vous avez oublié votre mot de passe ? Pas de souci. Entrez votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>
            </div>
            </div>
            <form method="post" class="wrapper-body">
                <div class="form-infos">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" name="email" id="email" class="form-input">
                </div>
                <div class="form-btn">
                    <button class="btn-primary" type="submit">Envoyer</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>