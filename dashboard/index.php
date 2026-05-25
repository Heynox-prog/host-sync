<?php
require_once "../admin/database/includes/db.php";
session_start();

require "../admin/functions/auth.php";

getAuth($pdo);
getCookieSession($pdo);

$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    <link rel="stylesheet" href="../static/css/layout/main.css">
    <link rel="stylesheet" href="../static/css/layout/themes.css">
    <link rel="stylesheet" href="../static/css/layout/header.css">
    <link rel="stylesheet" href="../static/css/layout/footer.css">
    <link rel="stylesheet" href="../static/css/pages/dashboard.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../static/js/themes/themes.js" defer></script>
    <script src="../static/js/layout/header.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../admin/layout/interface/header.php" ?>

    <main class="main-container">
        <div class="main-title">
            <h1 class="title">Mon tableau de bord</h1>
        </div>
        <div class="sources">
            <a href="/" class="source-notActive">Accueil</a>
            <span class="source-separator"> / </span>
            <a href="../dashboard/" class="source-active">Dashboard</a>
        </div>
    </main>

    <section class="dashboard-container">
        <div class="dashboard">
            <div class="dashboard-left">
                <div class="dashboard-profile">
                    <div class="profile-title">
                        <h2><?= htmlspecialchars($_SESSION["user_name"] ?? "") ?></h2>
                    </div>
                    <div class="profile-infos">
                        <ul class="dashboard-list">
                            <li class="dashboard-list-item"><?= htmlspecialchars($_SESSION["user_email"] ?? "") ?></li>
                            <li class="dashboard-list-item"><?= htmlspecialchars($_SESSION["id_client"] ?? "") ?></li>
                            <li class="dashboard-list-item"><?= htmlspecialchars($_SESSION["user_role"] ?? "") ?></li>
                        </ul>
                    </div>
                    <div class="dashboard-link-primary">
                        <a href="./profile/">Modifier le profil</a>
                    </div>
                </div>
                <div class="dashboard-contact">
                    <div class="dashboard-left-title">
                        <h3>Gestion des contacts</h3>
                    </div>
                    <div class="contact-list">
                        <ul class="dashboard-list contact-list">
                            <?php if (isset($_SESSION["user_contacts"]) && is_array($_SESSION["user_contacts"])): ?>
                                <?php foreach ($_SESSION["user_contacts"] as $contact): ?>
                                    <li class="dashboard-list-item"><?= htmlspecialchars($contact) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="dashboard-list-item"><i class="fa-solid fa-user dashboard-fa"></i> Aucun contact trouvé</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="dashboard-link-primary">
                        <a href="./contact/"><i class="fa-solid fa-user-plus dashboard-fa"></i> Ajouter un contact</a>
                    </div>
                </div>
                <div class="dashboard-nav">
                    <div class="dashboard-left-title">
                        <h3>Navigation</h3>
                    </div>
                    <div class="dashboard-nav-links">
                        <a href="../services/" class="dashboard-nav-link"><i class="fa-solid fa-basket-shopping dashboard-fa"></i> <span>Commander un service</span></a>
                        <a href="./profile/" class="dashboard-nav-link"><i class="fa-solid fa-user dashboard-fa"></i> <span>Mon profil</span></a>
                        <a href="./profile/solde/ajouter-des-fonds" class="dashboard-nav-link"><i class="fa-solid fa-money-bill dashboard-fa"></i> <span>Ajouter des fonds</span></a>
                        <a href="../user/deconnexion" class="dashboard-nav-link"><i class="fa-solid fa-arrow-right-from-bracket dashboard-fa"></i> <span>Déconnexion</span></a>
                    </div>
                </div>
            </div>
            <div class="dashboard-right">
                <div class="cards-tiles">
                    <a href="#" class="card-container">
                        <div class="card-row1">
                            <i class="fa-solid fa-desktop card-label"></i>
                        </div>
                        <div class="card-row2">
                            <span class="count"><?= htmlspecialchars($service_count ?? 0) ?></span>
                        </div>
                        <div class="card-row3">
                            <h3 class="card-title">
                                Services
                            </h3>
                        </div>
                    </a>

                    <a href="#" class="card-container">
                        <div class="card-row1">
                            <i class="fa-solid fa-file-circle-xmark card-label"></i>
                        </div>
                        <div class="card-row2">
                            <span class="count"><?= htmlspecialchars($service_count ?? 0) ?></span>
                        </div>
                        <div class="card-row3">
                            <h3 class="card-title">
                                Factures impayées
                            </h3>
                        </div>
                    </a>

                    <a href="#" class="card-container">
                        <div class="card-row1">
                            <i class="fa-solid fa-tag card-label"></i>
                        </div>
                        <div class="card-row2">
                            <span class="count"><?= htmlspecialchars($tickets_count ?? 0) ?></span>
                        </div>
                        <div class="card-row3">
                            <h3 class="card-title">
                                Tickets ouverts
                            </h3>
                        </div>
                    </a>
                </div>
                <div class="products-container">
                    <div class="products-header">
                        <div class="title">
                            <h3>Vos produits/services actifs</h3>
                        </div>
                        <div class="tag">
                            <i class="fa-solid fa-desktop dashboard-fa"></i>
                        </div>
                    </div>
                    <div class="products-body">
                        <?php if (isset($_SESSION["user_services"]) && is_array($_SESSION["user_services"])): ?>
                            <a href="./services/<?= htmlspecialchars($service["id"]) ?>" class="product-item-container">
                                <div class="product-item">
                                    <div class="product-item-header">
                                        <div class="product-name"><?= htmlspecialchars($service["name"] ?? "inconnu") ?></div>
                                        <span>-</span>
                                        <div class="product-status"><?= htmlspecialchars($service["status"] ?? "fermé") ?></div>
                                    </div>
                                </div>
                            </a>
                        <?php else: ?>
                            <div class="products-notFound">
                                <p>Aucun service actif trouvé</p>
                                <a href="../services/">Commander un nouveau service</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require "../admin/layout/interface/footer.php" ?>
</body>

</html>