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
            <form action="./functions/create_user.php" method="post" class="form-container">
                <h1 class="title">
                    Inscription
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
                    <!-- <div class="flex-inputs" style="display: none;"> -->
                    <div class="flex-inputs">
                        <div class="form-row-elem">
                            <label for="first_name">Prénom</label>
                            <input type="first_name" id="first_name" name="first_name" class="form-input">
                        </div>
                        <div class="form-row-elem">
                            <label for="last_name">Nom d'utilisateur</label>
                            <input type="last_name" id="last_name" name="last_name" class="form-input">
                        </div>
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
                <div class="form-row">
                    <div class="form-row-elem">
                        <label for="password_confirm" class="form-label">Confirmez le mot de passe:</label>
                    </div>
                    <div class="form-row-elem">
                        <input type="password" name="password_confirm" id="password_confirm" class="form-input">
                    </div>
                </div>

                <?php if (isset($_SESSION["status-error"])): ?>
                    <div class="form-status-container">
                        <p class="status-error">
                            <?= htmlspecialchars($_SESSION["status-error"]) ?>
                            <?php unset($_SESSION["status-error"]) ?>
                        </p>
                    </div>
                <?php elseif (isset($_SESSION["status-success"])): ?>
                    <div class="form-status-container">
                        <p class="status-success">
                            <?= htmlspecialchars($_SESSION["status-success"]) ?>
                            <?php unset($_SESSION["status-success"]) ?>
                        </p>
                    </div>
                <?php endif; ?>
                
                <div class="form-submit">
                    <button class="submit-btn">S'inscrire</button>
                </div>
                <div class="form-separator"></div>
                <div class="form-more">
                    <p class="form-more--p">
                        Déjà inscrit ? <a href="./connexion">Se connecter</a>
                    </p>
                </div>
            </form>
        </div>
    </main>
</body>

</html>