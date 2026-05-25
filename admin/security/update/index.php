<?php
require_once "../../database/includes/db.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "administrateur") {
    header("Location: /");
    exit();
}

$stmt = $pdo->prepare("SELECT id, firstname, email, role FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "./functions/research_user.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des utilisateurs</title>

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../../static/js/themes/themes.js" defer></script>

    <style>
        .gui-update_role {
            display: none;
        }

        .open {
            position: absolute;
            bottom: 15px;
            left: 15px;
            width: calc(100% - 30px);
            background-color: #d1d1d1;
            border: 1px solid #000;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .grid-container {
            display: grid;
            gap: 10px;
            margin-top: 20px;
        }

        .grid-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 10px;
            align-items: center;
        }

        .grid-header {
            font-weight: bold;
            background-color: #ddd;
        }

        .grid-cell {
            padding: 5px;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .grid-row {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                gap: 5px;
            }

            .grid-cell::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
            }

            .grid-header {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="GET">
            <input type="text" name="q" placeholder="Rechercher un utilisateur..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button type="submit">Rechercher</button>
        </form>

        <div class="grid-container">
            <div class="grid-row grid-header">
                <div class="grid-cell">ID</div>
                <div class="grid-cell">Nom d'utilisateur</div>
                <div class="grid-cell">Email</div>
                <div class="grid-cell">Rôle</div>
                <div class="grid-cell">Actions</div>
            </div>

            <?php foreach ($users as $user): ?>
                <div class="grid-row">
                    <div class="grid-cell"><?= htmlspecialchars($user['id']) ?></div>
                    <div class="grid-cell"><?= htmlspecialchars($user['firstname'] ?? "Non défini") ?></div>
                    <div class="grid-cell"><?= htmlspecialchars($user['email']) ?></div>
                    <div class="grid-cell"><?= htmlspecialchars($user['role'] ?? 'Non défini') ?></div>
                    <div class="grid-cell">
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                            <button class="toggler-gui">Fonctions</button>

                            <div class="gui-update_role">
                                <div class="elem-wrapper">
                                    <?= htmlspecialchars($user['id']) ?><br>
                                    <?= htmlspecialchars($user['firstname'] ?? "Non défini") ?><br>
                                    <?= htmlspecialchars($user['email']) ?><br>
                                    <?= htmlspecialchars($user['role'] ?? 'Non défini') ?>
                                </div>

                                <?php foreach (['administrateur', 'modérateur', 'communication', 'vip', 'utilisateur'] as $role): ?>
                                    <form method="post" action="./functions/update_user.php">
                                        <input type="hidden" name="user_id" value="<?= $user["id"] ?>">
                                        <input type="submit" name="role" value="<?= $role ?>" class="submit-btn">
                                    </form>
                                <?php endforeach; ?>

                                <hr>
                                <form method="post" action="./functions/delete_user.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer le compte <?= htmlspecialchars($user['firstname']) ?> ?');">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!empty($_SESSION["user_notFound"])): ?>
                <div class="form-error">
                    <p class="form-error-content">
                        <svg  xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" ><!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M14.29 8.29 12 10.59 9.71 8.29 8.29 9.71 10.59 12 8.29 14.29 9.71 15.71 12 13.41 14.29 15.71 15.71 14.29 13.41 12 15.71 9.71 14.29 8.29z"></path><path d="m12,2C6.49,2,2,6.49,2,12c0,2.12.68,4.19,1.93,5.9l-1.75,2.53c-.21.31-.24.7-.06,1.03.17.33.51.54.89.54h9c5.51,0,10-4.49,10-10S17.51,2,12,2Zm0,18h-7.09l1.09-1.57c.26-.37.23-.88-.06-1.22-1.25-1.45-1.93-3.3-1.93-5.21,0-4.41,3.59-8,8-8s8,3.59,8,8-3.59,8-8,8Z"></path></svg>
                        <?= htmlspecialchars($_SESSION["user_notFound"]) ?>

                        <?php unset($_SESSION["user_notFound"]); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        togglers = document.querySelectorAll(".toggler-gui")
        guis = document.querySelectorAll(".gui-update_role")

        togglers.forEach((toggler, index) => {
            toggler.addEventListener("click", () => {
                gui = guis[index]
                gui.classList.toggle("open")
            })
        });
    </script>
</body>

</html>