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
  <title>Création d'articles</title>

  <link rel="stylesheet" href="../../../static/css/layout/main.css">
  <link rel="stylesheet" href="../../../static/css/layout/themes.css">
  <link rel="stylesheet" href="../../../static/css/layout/header.css">
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
      <h1 class="main-title">Création d'articles</h1>
      <h2 class="main-subtitle">Vous pourrez ci-dessous créer de nouveaux articles qui seront disponible sur le site.</h2>
    </div>
  </main>

  <div class="container">
    <form action="./functions/create.php" method="post" class="form-container" enctype="multipart/form-data">
      <div class="form-row">
        <label for="title" class="form-label">Titre de l'article:</label>
        <input type="text" id="title" name="article_title" class="form-input" placeholder="Entrez le titre de l'article.">
      </div>
      <div class="form-row">
        <label for="article_desc" class="form-label">Description:</label>
        <textarea id="article_desc" name="article_desc" class="form-textarea article_desc-textarea" placeholder="Entrez la description de l'article (max. 100 caractères)."></textarea>
      </div>
      <div class="form-row">
        <label for="content" class="form-label">Contenu:</label>
        <textarea id="content" name="article_content" class="form-textarea" placeholder="Entrez le contenu de l'article (max. 5000 caractères)."></textarea>
      </div>
      <div class="form-row">
        <select name="article_category" id="categories">
          <option value="" disabled selected hidden>Choississez une catégorie</option>
          <option value="patch-notes">Patch-Notes</option>
          <option value="actualite">Actualités</option>
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
        <button class="submit-btn">Créer l'article</button>
      </div>
    </form>
  </div>
</body>

</html>