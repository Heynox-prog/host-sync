<?php
require_once "../admin/database/includes/db.php";
session_start();

$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="../static/css/layout/main.css">
    <link rel="stylesheet" href="../static/css/layout/themes.css">
    <link rel="stylesheet" href="../static/css/layout/header.css">
    <link rel="stylesheet" href="../static/css/pages/login-logout.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../static/js/themes/themes.js" defer></script>
    <script src="../static/js/layout/header.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../admin/layout/interface/header.php" ?>

    <main class="main-container">
        <div class="container">
            <form action="./functions/connect_user.php" method="post" class="form-container">
                <h1 class="title">
                    Connexion à l'espace client
                </h1>
                <div class="form-row">
                    <div class="form-row-elem">
                        <label for="email" class="form-label">E-mail:</label>
                    </div>
                    <div class="form-row-elem">
                        <input type="text" name="email" id="email" class="form-input">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row-elem">
                        <label for="password" class="form-label">Mot de passe:</label>
                    </div>
                    <div class="form-row-elem">
                        <input type="password" name="password" id="password" class="form-input">
                    </div>
                </div>
                <div class="form-checkbox">
                    <div class="form-row-elem">
                        <input type="checkbox" name="remember_me" id="remember_me" class="form-checkbox--input">
                    </div>
                    <div class="form-row-elem">
                        <label for="remember_me">Se souvenir de moi</label>
                    </div>
                </div>
                <?php if (!empty($_SESSION["status-error"])): ?>
                    <div class="status">
                        <p class="status-error">
                            <?= htmlspecialchars($_SESSION["status-error"]) ?>

                            <?php unset($_SESSION["status-error"]); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION["status-success"])): ?>
                    <div class="register-status">
                        <p class="status-success">
                            <?= htmlspecialchars($_SESSION["status-success"]) ?>

                            <?php unset($_SESSION["status-success"]); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION["status-warning"])): ?>
                    <div class="register-status">
                        <p class="status-warning">
                            <?= htmlspecialchars($_SESSION["status-warning"]) ?>

                            <?php unset($_SESSION["status-warning"]); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION["status-not-verified"])): ?>
                    <div class="register-status">
                        <p class="status-warning">
                            <?= htmlspecialchars($_SESSION["status-not-verified"]) ?>

                            <?php unset($_SESSION["status-not-verified"]); ?>
                        </p>
                        <p class="resend-verification">
                            Vous n'avez pas reçu d'e-mail de vérification ? <a href="./resend-verification.php">Renvoyer l'e-mail</a>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="form-submit">
                    <button class="submit-btn">Se connecter</button>
                </div>
                <div class="form-separator"></div>
                <div class="form-more">
                    <p class="form-more--p">
                        Pas encore inscrit ? <a href="./inscription">Créer un compte</a>
                    </p>
                </div>
            </form>
        </div>
    </main>
</body>

</html>