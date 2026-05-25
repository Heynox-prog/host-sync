<?php
require_once "../../database/includes/db.php";
session_start();

$allowed_roles = ['administrateur', 'communication'];

if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_role'], $allowed_roles)) {
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
  <title>Création de services</title>

  <link rel="stylesheet" href="../../../static/css/layout/main.css">
  <link rel="stylesheet" href="../../../static/css/layout/themes.css">
  <link rel="stylesheet" href="../../../static/css/layout/header.css">
  <link rel="stylesheet" href="../../../static/css/layout/footer.css">
  <link rel="stylesheet" href="../../static/css/form.css">

  <script src="https://kit.fontawesome.com/707bcbbdaa.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tiny.cloud/1/m23st9eyxc2njv0f84zuecfh01iyppeix6b4o3niocmz1hcu/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="../../../static/js/themes/themes.js" defer></script>
  <script src="../../../static/js/layout/header.js" defer></script>
  <script src="../../../static/js/layout/tinymce.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">
  <?php require "../../../admin/layout/interface/header.php"; ?>

  <main class="main-container">
    <div class="main-titles">
      <h1 class="main-title">Création de service (catégorie)</h1>
      <h2 class="main-subtitle">Vous pourrez ci-dessous créer de nouveaux sevices qui seront disponibles sur le site.</h2>
    </div>
  </main>

  <div class="container">
    <form action="./functions/create.php" method="post" class="form-container" enctype="multipart/form-data">
      <div class="form-row">
        <label for="title" class="form-label">Titre du service:</label>
        <input type="text" id="title" name="title" class="form-input" placeholder="Entrez le titre du service.">
      </div>
      <div class="form-row">
        <label for="short_description" class="form-label">Courte description:</label>
        <input type="text" id="short_description" name="short_description" class="form-input" placeholder="Entrez une courte description (max. 50 caractères).">
      </div>
      <div class="form-row">
        <label for="content" class="form-label">Longue description:</label>
        <textarea id="content" name="long_description" class="form-input" placeholder="Entrez une longue description (max. 500 caractères)."></textarea>
      </div>
      <div class="form-row">
        <label for="image" class="form-label">Image:</label>
        <input type="file" id="image" name="image" class="form-input" placeholder="Choisisez une image pour le service (conseillé 512x512).">
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

  <?php require "../../../admin/layout/interface/footer.php"; ?>
</body>

</html>