<div class="dialogBox-container">
    <div class="dialogBox-content">
        <div class="dialog-title">
            <h2>Êtes-vous sur de vouloir supprimer cet article ?</h2>
        </div>
        <div class="dialog-btns">
            <button class="warning-btn" onclick="dialog('close')">Annuler</button>
            <form action="/admin/pages/articles/delete-article.php?slug=<?= htmlspecialchars($article["slug"]) ?>" method="post">
                <button class="remove-btn" type="submit">Supprimer</button>
            </form>
        </div>
        <div class="line-anim"></div>
    </div>
</div>