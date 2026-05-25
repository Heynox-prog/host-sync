<?php
require_once "../../../database/includes/db.php";
session_start();

require "../../../functions/utilities.php";

$allowed_roles = ['administrateur', 'communication'];

if (!isset($_SESSION["token"]) || !in_array($_SESSION['user_role'], $allowed_roles)) {
    header("Location: /");
    exit;
}

$theme = $_COOKIE["theme"];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créations d'offres</title>

    <link rel="stylesheet" href="../../../../static/css/layout/main.css">
    <link rel="stylesheet" href="../../../../static/css/layout/themes.css">
    <link rel="stylesheet" href="../../../../static/css/layout/header.css">
    <link rel="stylesheet" href="../../../../static/css/layout/footer.css">
    <link rel="stylesheet" href="../../../../admin/static/css/form.css">

    <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
    <script src="../../../../static/js/themes/themes.js" defer></script>
    <script src="../../../../static/js/layout/header.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
    <?php require "../../../../admin/layout/interface/header.php"; ?>

    <main class="main-container">
    <div class="main-titles">
      <h1 class="main-title">Création des offres</h1>
      <h2 class="main-subtitle">Vous pourrez ci-dessous créer de nouvelles offres qui seront liées à un service.</h2>
    </div>
  </main>

  <div class="container">
    <form action="./functions/create.php" method="post" class="form-container" enctype="multipart/form-data">
      <div class="form-row">
        <label for="name" class="form-label">Nom de l'offre:</label>
        <input type="text" id="name" name="name" class="form-input" placeholder="Entrez le nom de l'offre.">
      </div>
      <div class="form-row">
        <label for="description" class="form-label">Description:</label>
        <input type="text" id="short_description" name="description" class="form-input" placeholder="Entrez une description (max. 100 caractères).">
      </div>
      <div class="form-row">
        <label for="image" class="form-label">Image:</label>
        <input type="file" id="image" name="image" class="form-input" placeholder="Choisisez une image pour le service (conseillé 512x512).">
      </div>
      <div class="form-row">
        <label for="price" class="form-label">Prix:</label>
        <input type="text" id="price" name="price" class="form-input" placeholder="Entrez le prix de l'offre.">
      </div>
      <div class="form-row">
        <label for="service_id" class="form-label">Service lié:</label>
        <select id="service_id" name="service_id" class="form-input">
          <option value="" disabled selected hidden>Choississez le service lié</option>
          <?php getServices($pdo); foreach (getServices($pdo) as $service): ?>
            <option value="<?= htmlspecialchars($service['id']) ?>"><?= htmlspecialchars($service['title']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <?php if (isset($_SESSION["status-error"])): ?>
        <div class="status">
          <p class="status-error">
            <?= htmlspecialchars($_SESSION["status-error"]) ?>

            <?php unset($_SESSION["status-error"]); ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION["status-success"])): ?>
        <div class="status">
          <p class="status-success">
            <?= htmlspecialchars($_SESSION["status-success"]) ?>

            <?php unset($_SESSION["status-success"]); ?>
          </p>
        </div>
      <?php endif; ?>
      <div class="form-submit">
        <button class="submit-btn">Créer le service</button>
      </div>
    </form>
  </div>

    <?php require "../../../../admin/layout/interface/footer.php"; ?>
</body>

</html>