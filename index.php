<?php
require_once "./admin/database/includes/db.php";
session_start();

require "./admin/functions/auth.php";
require "./admin/functions/utilities.php";

getCookieSession($pdo);

$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Host-Sync</title>

  <link rel="stylesheet" href="./static/css/layout/main.css">
  <link rel="stylesheet" href="./static/css/layout/themes.css">
  <link rel="stylesheet" href="./static/css/layout/header.css">
  <link rel="stylesheet" href="./static/css/layout/footer.css">
  <link rel="stylesheet" href="./static/css/pages/index.css">

  <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
  <script src="./static/js/themes/themes.js" defer></script>
  <script src="./static/js/layout/header.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
  <?php require "./admin/layout/interface/header.php"; ?>

  <div class="test" style="padding-top: 100px;">
    <?php
      if (isset($_SESSION["user_id"])) {
        echo '<div class="alert success-alert">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                <strong>Succès !</strong> Vous êtes connecté en tant que ' . htmlspecialchars(getUserLastName()) . '.
              </div>'
        ;
      }
      ?>
  </div>

  <main class="main-container">
    <div class="flex-row">
      <div class="flex-left">
        <div class="main-titles">
          <h1>Bienvenue sur Host-Sync</h1>
          <h2>L'hébergement accessible à tous.</h2>
        </div>
        <div class="flex-center">
          <div class="section-title-divider"></div>
        </div>
        <div class="main-btn">
          <a href="#nos-services" class="primary-link">Découvrez nos services phares</a>
          <a href="./about/" class="secondary-link">Apprenez-en plus</a>
        </div>
      </div>
      <div class="flex-right">
        <img src="./static/images/main/hero-img-min.webp" alt="Logo principal" title="Logo principal" class="main-img">
      </div>
    </div>
  </main>

  <section class="section-container about" id="a-propos">
    <div class="about-cards" id="pourquoi-nous">
      <div class="about-card-container">
        <div class="about-card-header">
          <img src="./static/images/main/clock.webp" alt="Fiabilité" title="Fiabilité" class="about-img">
          <h2>Fiabilité</h2>
        </div>
        <div class="about-card-body">
          <p>
            Nous assurons une stabilité et une performance optimale de nos services pour garantir la continuité de vos projets en ligne.
          </p>
        </div>
      </div>

      <div class="about-card-container">
        <div class="about-card-header">
          <img src="./static/images/main/perform.webp" alt="Innovation" title="Innovation" class="about-img">
          <h2>Innovation</h2>
        </div>
        <div class="about-card-body">
          <p>
            Nous adoptons les dernières technologies et tendances pour offrir des solutions d'hébergement à la pointe et répondre aux besoins futurs.
          </p>
        </div>
      </div>

      <div class="about-card-container">
        <div class="about-card-header">
          <img src="./static/images/main/30-day.webp" alt="Support" title="Support" class="about-img">
          <h2>Support</h2>
        </div>
        <div class="about-card-body">
          <p>
            Notre équipe de support dédiée est là pour vous aider, 24/7, offrant une assistance et une expertise inégalées quand vous en avez besoin.
          </p>
        </div>
      </div>
    </div>
    <div class="about-text">
      <h3>
        Host-Sync assure Fiabilité, Innovation et un Support de qualité vous assurant une expérience d'hébergement optimale. Entre hébergement de bots discord et des serveurs de jeux, nous avons la solution qu'il vous faut.
      </h3>
    </div>
  </section>

  <section class="section-container services" id="nos-services">
    <div class="section-titles">
      <h2>Nos services</h2>
      <h3>Vous retrouverez ci dessous la liste des services que propose Host-Sync</h3>

      <div class="section-title-divider"></div>
    </div>
    <div class="grid-container">
      <div class="cards-container">
        <?php if (getServicesCount($pdo) > 0): ?>
          <?php foreach (getServices($pdo) as $service): ?>
            <div class="card-container card-service">
              <a href="/services/<?= htmlspecialchars($service['slug']) ?>" class="card-link">
                <div class="card-items">
                  <div class="card-row1">
                    <div class="card-service-img">
                      <img src="<?= htmlspecialchars($service['image_path'] ?? '') ?>" alt="<?= htmlspecialchars($service['title']) ?>" class="card-image image-service">
                    </div>
                    <div class="card-title-container">
                      <h3 class="card-title">
                        <?= htmlspecialchars($service["title"]) ?>
                      </h3>
                    </div>
                  </div>
                  <div class="card-row2">
                    <p class="card-description">
                      <?= htmlspecialchars($service["short_description"]) ?>
                    </p>
                  </div>
                  <div class="card-row3">
                    <h3>A partir de <?= htmlspecialchars($service["price"] ?? "?") ?>€</h3>
                  </div>
                  <div class="line-anim"></div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="content-void">
            <p>
              Aucun service n'a été trouvé.
            </p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php if (getArticlesCount($pdo) > 0): ?>
      <div class="section-more">
        <div class="more-limit">
          <a href="./services/liste" class="section-more__link link-flex-between">Voir tous les services <i class="fa-solid fa-arrow-right more-link-fa"></i></a>
        </div>
      </div>
    <?php endif; ?>
  </section>

  <section class="section-container group" id="notre-equipe">
    <?php
    $stmt = $pdo->prepare("SELECT * FROM offers WHERE service_id = 17");
    $stmt->execute();
    $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (count($offers) > 0): ?>
      <div class="section-titles">
        <h2>Nos offres</h2>
        <h3>Découvrez nos offres pour chaque service</h3>

        <div class="section-title-divider"></div>
      </div>
      <div class="grid-container">
        <div class="cards-container">
          <?php foreach ($offers as $offer): ?>
            <div class="card-container card-offer">
              <a href="#" class="card-link">
                <div class="card-items">
                  <h4 class="card-title"><?= htmlspecialchars($offer['name']) ?></h4>
                  <p class="card-description"><?= htmlspecialchars($offer['description']) ?></p>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php else: ?>
      <div class="content-void">
        <p>
          Aucune offre n'a été trouvée.
        </p>
      </div>
    <?php endif; ?>
  </section>

  <section class="section-container articles" id="nos-articles">
    <div class="section-titles">
      <h2>Nos articles</h2>
      <h3>Suivez l'actualité de Host-Sync avec nos articles</h3>

      <div class="section-title-divider"></div>
    </div>
    <div class="grid-container">
      <div class="cards-container">
        <?php if (getArticlesCount($pdo) > 0): ?>
          <?php foreach (getArticlesLimit($pdo) as $article): ?>
            <div class="card-container card-article">
              <a href="/articles/<?= htmlspecialchars($article['slug']) ?>" class="card-link">
                <div class="card-items items-article">
                  <div class="card-row1 row1-article">
                    <img src="<?= htmlspecialchars($article['image_path'] ?? '/static/images/article/default/default-img.jpg') ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="card-image image-article">
                  </div>
                  <div class="card-row2 row2-article">
                    <h3 class="card-title">
                      <?= htmlspecialchars($article["title"]) ?>
                    </h3>
                  </div>
                  <div class="card-row3 row3-article">
                    <span>Lire l'article</span> <i class="fa-solid fa-arrow-right more-link-fa"></i>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="content-void">
            <p>
              Aucun article n'a été trouvé.
            </p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php if (getArticlesCount($pdo) > 0): ?>
      <div class="section-more">
        <div class="more-limit">
          <a href="./articles/liste" class="section-more__link link-flex-between">Voir tous les articles <i class="fa-solid fa-arrow-right more-link-fa"></i></a>
        </div>
      </div>
    <?php endif; ?>
  </section>
  <section class="section-container faq" id="faq"></section>

  <?php require "./admin/layout/interface/footer.php"; ?>
</body>

</html>