<?php
require_once "../../admin/database/includes/db.php";
session_start();

require "../../admin/functions/utilities.php";
require "../../admin/functions/auth.php";

getAuth($pdo);

$user_id = $_SESSION["user_id"];

if ($user_id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $user_infos = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_lastname = trim($_POST["lastname"] ?? "");
    $new_firstname = trim($_POST["firstname"] ?? "");
    $new_email = trim($_POST["email"] ?? "");
    $old_psw = trim($_POST["old_psw"] ?? "");
    $new_password = trim($_POST["new_psw"] ?? "");
    $confirm_new_password = trim($_POST["confirm_new_psw"] ?? "");

    $error = "";
    $success = "";

    $update_fields = [];
    $update_values = [];

    if ($new_lastname !== "") {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE lastname = ? AND id != ?");
        $stmt->execute([$new_lastname, $user_id]);
        $existingUser = $stmt->fetchColumn();
        
        if (strlen($new_lastname) < 3) {
            $error = "Le nom de famille doit contenir au moins 3 caractères.";
            $_SESSION["error"] = $error;
        } else {
            $update_fields[] = "lastname = ?";
            $update_values[] = $new_lastname;
        }
    }

    if (!$error && $new_firstname !== "") {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE firstname = ? AND id != ?");
        $stmt->execute([$new_firstname, $user_id]);
        $existingUser = $stmt->fetchColumn();

        if (strlen($new_firstname) < 3) {
            $error = "Le prénom doit contenir au moins 3 caractères.";
            $_SESSION["error"] = $error;
        } else {
            $update_fields[] = "firstname = ?";
            $update_values[] = $new_firstname;
        }
    }

    if (!$error && $new_email !== "") {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$new_email]);
        $existingUser = $stmt->fetchColumn();

        if ($existingUser > 0) {
            $error = "Un utilisateur avec cet e-mail existe déjà !";
            $_SESSION["error"] = $error;
        } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email n'est pas valide.";
            $_SESSION["error"] = $error;
        } else {
            $update_fields[] = "email = ?";
            $update_values[] = $new_email;
        }
    }

    if (!$error && ($old_psw !== "" || $new_password !== "" || $confirm_new_password !== "")) {
        if ($old_psw === "" || $new_password === "" || $confirm_new_password === "") {
            $error = "Pour modifier le mot de passe, veuillez remplir tous les champs correspondants.";
            $_SESSION["error"] = $error;
        } elseif (strlen($new_password) < 7) {
            $error = "Le nouveau mot de passe doit contenir au moins 7 caractères.";
            $_SESSION["error"] = $error;
        } elseif ($new_password !== $confirm_new_password) {
            $error = "Les mots de passe ne correspondent pas.";
            $_SESSION["error"] = $error;
        } else {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $old_infos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$old_infos || !password_verify($old_psw, $old_infos['password'])) {
                $error = "L'ancien mot de passe est incorrect.";
                $_SESSION["error"] = $error;
            } else {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $update_fields[] = "password = ?";
                $update_values[] = $new_password_hashed;
            }
        }
    }

    if (!$error) {
        if (count($update_fields) > 0) {
            $sql = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE id = ?";
            $update_values[] = $user_id;
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute($update_values);
                $success = "Profil mis à jour avec succès !";

                $_SESSION["success"] = $success;
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                $_SESSION["error"] = $error;
            }
        } else {
            $error = "Aucun champ à mettre à jour.";
        }
    }
}

$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    <link rel="stylesheet" href="../../static/css/layout/main.css">
    <link rel="stylesheet" href="../../static/css/layout/themes.css">
    <link rel="stylesheet" href="../../static/css/layout/header.css">
    <link rel="stylesheet" href="../../static/css/layout/footer.css">
    <link rel="stylesheet" href="../../static/css/pages/profil.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../static/js/themes/themes.js" defer></script>
    <script src="../../static/js/layout/header.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../../admin/layout/interface/header.php" ?>

    <main class="main-container">
        <div class="main-title">
            <h1 class="title">Mon profile</h1>
            <h2 class="subtitle">Vous pouvez mettre à jour vos informations personnelles ici.</h2>
        </div>
        <div class="sources">
            <a href="/" class="source-notActive">Accueil</a>
            <span class="source-separator"> / </span>
            <a href="../" class="source-notActive">Dashboard</a>
            <span class="source-separator"> / </span>
            <a href="../profile" class="source-active">Profile</a>
        </div>
    </main>

    <div class="container">
        <div class="leftBar">
            <div class="balance-card">
                <div class="balance">
                    <div class="balance-header">
                        <h3>Votre solde</h3>
                        <p><?= htmlspecialchars(getUserBalance($pdo)) ?>€</p>
                    </div>
                    <div class="balance-body">
                        <p><span>Dépôt minimum</span> 5€</p>
                        <p><span>Dépôt maximum</span> 100€</p>
                        <p><span>Solde maximal</span> 1000€</p>
                    </div>
                </div>
                <div class="balance-footer">
                    <i class="fa-solid fa-circle-info"></i> Aucun dépôt n'est remboursable
                </div>
            </div>
            <div class="profile-contact">
                <div class="profile-left-title">
                    <h3>Gestion des contacts</h3>
                </div>
                <div class="contact-list">
                    <ul class="profile-list contact-list">
                        <?php if (isset($_SESSION["user_contacts"]) && is_array($_SESSION["user_contacts"])): ?>
                            <?php foreach ($_SESSION["user_contacts"] as $contact): ?>
                                <li class="profile-list-item"><?= htmlspecialchars($contact) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="profile-list-item"><i class="fa-solid fa-user profile-fa"></i> Aucun contact trouvé</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="profile-link-primary">
                    <a href="./contact/"><i class="fa-solid fa-user-plus profile-fa"></i> Ajouter un contact</a>
                </div>
            </div>
            <div class="profile-nav">
                <div class="profile-left-title">
                    <h3>Navigation</h3>
                </div>
                <div class="profile-nav-links">
                    <a href="../services/" class="profile-nav-link"><i class="fa-solid fa-basket-shopping profile-fa"></i> <span>Commander un service</span></a>
                    <a href="./profile/" class="profile-nav-link"><i class="fa-solid fa-user profile-fa"></i> <span>Mon profil</span></a>
                    <a href="./solde/ajouter-des-fonds" class="profile-nav-link"><i class="fa-solid fa-money-bill profile-fa"></i> <span>Ajouter des fonds</span></a>
                    <a href="../user/deconnexion" class="profile-nav-link"><i class="fa-solid fa-arrow-right-from-bracket profile-fa"></i> <span>Déconnexion</span></a>
                </div>
            </div>
        </div>
        <form method="post" class="form-container">
            <div class="section">
                <div class="form-row">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" class="form-input" value="<?= htmlspecialchars($user_infos["username"] ?? '') ?>">
                </div>
                <div class="form-row">
                    <label for="firstname">Prénom:</label>
                    <input type="text" id="firstname" name="firstname" class="form-input" value="<?= htmlspecialchars($user["firstname"] ?? '') ?>">
                </div>
                <div class="form-row">
                    <label for="email">Mail:</label>
                    <input type="text" id="email" name="email" class="form-input" value="<?= htmlspecialchars($user_infos["email"] ?? '') ?>">
                </div>
                <div class="form-row">
                    <label for="id_client">Numéro client:</label>
                    <input type="text" id="id_client" name="id_client" class="form-input" value="<?= htmlspecialchars($user_infos["id_client"] ?? '') ?>" readonly>
                </div>
                <div class="form-row">
                    <label for="old_psw">Modifier le mot de passe:</label>
                    <input type="password" id="old_psw" name="old_psw" class="form-input" placeholder="Tapez ici votre ancien mot de passe.">
                    <div class="flex-inputs">
                        <input type="password" id="new_psw" name="new_psw" class="form-input" placeholder="Tapez ici votre nouveau mot de passe.">
                        <input type="password" id="confirm_new_psw" name="confirm_new_psw" class="form-input" placeholder="Retapez votre nouveau mot de passe.">
                    </div>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="form-status-container">
                        <p class="status-error">
                            <?= htmlspecialchars($error) ?>
                        </p>
                    </div>
                <?php elseif (!empty($success)): ?>
                    <div class="form-status-container">
                        <p class="status-success">
                            <?= htmlspecialchars($success) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="btn-updater">
                <button class="btn-update">Mise à jour du profil</button>
            </div>
        </form>
    </div>

    <?php require "../../admin/layout/interface/footer.php" ?>
</body>

</html>