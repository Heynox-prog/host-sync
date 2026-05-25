<header class="header-container">
    <div class="header-left">
        <div class="header-img">
            <img src="/static/images/logo/header/light-logo_h.png" alt="Logo" class="header--img">
        </div>
        <div class="header-responsive">
            <button class="toggle-responsive-header">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </button>
        </div>
        <div class="header-nav">
            <nav class="topNav-container">
                <a href="/" class="topNav-link topNav-left-link link-animate">Accueil <i class="fa-solid fa-house fa-anime"></i></a>
                <a href="/about" class="topNav-link link-animate">À propos <i class="fa-solid fa-info-circle fa-anime"></i></a>
                <a href="/services/" class="topNav-link link-animate">Nos services <i class="fa-solid fa-briefcase fa-anime"></i></a>
                <a href="/contact" class="topNav-link link-animate">Nous contacter <i class="fa-solid fa-envelope fa-anime"></i></a>
                <a href="/equipe/liste" class="topNav-link link-animate">Notre équipe <i class="fa-solid fa-users fa-anime"></i></a>
                <a href="/articles/liste" class="topNav-link link-animate">Articles <i class="fa-solid fa-newspaper fa-anime"></i></a>
                <a href="/faq" class="topNav-link link-animate">FAQ's <i class="fa-solid fa-question fa-anime"></i></a>
                <!-- <div class="topNav-dropdown-container dropdown-container-left">
                    <button class="dropdown-toggler">
                        Légal <i class="fa-solid fa-chevron-right dropdown-chevron"></i>
                    </button>
                    <div class="dropdown-links dropdown-links-left">
                        <a href="/legal/cgu" class="link-flex-gap"><i class="fa-solid fa-gavel fa-anime"></i> CGU</a>
                        <a href="/legal/cgv" class="link-flex-gap"><i class="fa-solid fa-gavel fa-anime"></i> CGV</a>
                        <a href="/legal/cookies" class="link-flex-gap"><i class="fa-solid fa-cookie fa-anime"></i> Cookies</a>
                        <a href="/legal/reglement-communautaire" class="link-flex-gap"><i class="fa-solid fa-book-open fa-anime"></i> Règlement communautaire</a>
                    </div>
                </div>
                <div class="topNav-dropdown-container dropdown-container-left">
                    <button class="dropdown-toggler">
                        Réseaux <i class="fa-solid fa-chevron-right dropdown-chevron"></i>
                    </button>
                    <div class="dropdown-links dropdown-links-left">
                        <a href="https://discord.gg/NyYF3NfyUU" class="link-flex-gap"><i class="fa-brands fa-discord fa-anime"></i> Discord</a>
                        <a href="https://www.instagram.com/" class="link-flex-gap"><i class="fa-brands fa-instagram fa-anime"></i> Instagram</a>
                        <a href="https://www.youtube.com/" class="link-flex-gap"><i class="fa-brands fa-youtube fa-anime"></i> Youtube</a>
                    </div>
                </div>
                <div class="topNav-dropdown-container dropdown-container-left">
                    <button class="dropdown-toggler">
                        Liens utiles <i class="fa-solid fa-chevron-right dropdown-chevron"></i>
                    </button>
                    <div class="dropdown-links dropdown-links-left">
                        <a href="/#a-propos" class="link-flex-gap"><i class="fa-solid fa-info-circle fa-anime"></i> À propos</a>
                        <a href="/#nos-services" class="link-flex-gap"><i class="fa-solid fa-briefcase fa-anime"></i> Nos services</a>
                        <a href="/#nous-contacter" class="link-flex-gap"><i class="fa-solid fa-envelope fa-anime"></i> Nous contacter</a>
                        <a href="/#notre-equipe" class="link-flex-gap"><i class="fa-solid fa-users fa-anime"></i> Notre équipe</a>
                        <a href="/#nos-articles" class="link-flex-gap"><i class="fa-solid fa-newspaper fa-anime"></i> Articles</a>
                        <a href="/#faq" class="link-flex-gap"><i class="fa-solid fa-question fa-anime"></i> Questions fréquentes</a>
                    </div>
                </div> -->

                <div class="topNav-mobile-right-section">
                    <div class="topNav-mobile-right-section-menu">
                        <div class="topNav-dropdown-container">
                            <button class="dropdown-toggler">
                                <i class="fa-regular fa-circle-user fa-theme topNav-right-icon"></i>
                            </button>
                            <div class="dropdown-links dropdown-links-right dropdown-links-right-mobile">
                                <?php if (isset($_SESSION["user_id"])): ?>
                                    <a href="/dashboard/profile/" class="link-flex-between dropdown-link-right">Mon profil <i class="fa-solid fa-user"></i></a>
                                    <a href="/dashboard/" class="link-flex-between dropdown-link-right">Tableau de bord <i class="fa-solid fa-clipboard-user"></i></a>
                                    <a href="/dashboard/settings/" class="link-flex-between dropdown-link-right">Paramètres <i class="fa-solid fa-gear"></i></a>
                                    <a href="/user/deconnexion" class="link-flex-between dropdown-link-right">Déconnexion <i class="fa-solid fa-right-from-bracket"></i></a>
                                    <div class="dropdown-separator"></div>
                                    <div class="dropdown-userSpace-infos">
                                        <p class="userSpace-info"><?= htmlspecialchars($_SESSION["user_firstname"]) ?></p>
                                        <p class="userSpace-info">
                                            <?php if ($_SESSION["user_role"] === "administrateur"): ?>
                                                <i class="fa-solid fa-shield-halved"></i>
                                            <?php endif; ?>
                                            <?= htmlspecialchars($_SESSION["user_role"]) ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <a href="/user/connexion" class="link-flex-between dropdown-link-right">Se connecter</a>
                                    <a href="/user/inscription" class="link-flex-between dropdown-link-right">S'inscrire</a>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "administrateur"): ?>
                                <div class="topNav-dropdown-container">
                                    <button class="dropdown-toggler">
                                        <i class="fa-solid fa-user-tie fa-theme topNav-right-icon"></i>
                                    </button>
                                    <div class="dropdown-links dropdown-links-right dropdown-links-right-mobile">
                                        <a href="/admin/pages/pages/dashboard/" class="link-flex-between dropdown-link-right">Tableau de bord</a>
                                        <a href="/admin/security/update/" class="link-flex-between dropdown-link-right">Utilisateurs</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="theme-choice">
                        <button class="theme-toggler" onclick="toggleTheme()">
                            <i class="fa-solid fa-sun topNav-right-icon"></i>
                            <i class="fa-solid fa-moon topNav-right-icon"></i>
                        </button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="header-right">
        <div class="topNav-dropdown-container">
            <button class="dropdown-toggler">
                <i class="fa-regular fa-circle-user fa-theme topNav-right-icon"></i>
            </button>
            <div class="dropdown-links dropdown-links-right dropdown-links-right-mobile">
                <?php if (isset($_SESSION["user_id"])): ?>
                    <a href="/dashboard/profile/" class="link-flex-between dropdown-link-right">Mon profil <i class="fa-solid fa-user"></i></a>
                    <a href="/dashboard/" class="link-flex-between dropdown-link-right">Tableau de bord <i class="fa-solid fa-clipboard-user"></i></a>
                    <a href="#" class="link-flex-between dropdown-link-right">Paramètres <i class="fa-solid fa-gear"></i></a>
                    <a href="/user/deconnexion" class="link-flex-between dropdown-link-right">Déconnexion <i class="fa-solid fa-right-from-bracket"></i></a>
                    <div class="dropdown-separator"></div>
                    <div class="dropdown-userSpace-infos">
                        <p class="userSpace-info"><?= htmlspecialchars($_SESSION["user_firstname"]) ?></p>
                        <p class="userSpace-info">
                            <?php if ($_SESSION["user_role"] === "administrateur"): ?>
                                <i class="fa-solid fa-shield-halved"></i>
                            <?php endif; ?>
                            <?= htmlspecialchars($_SESSION["user_role"]) ?>
                        </p>
                    </div>
                <?php else: ?>
                    <a href="/user/connexion" class="link-flex-between dropdown-link-right">Se connecter</a>
                    <a href="/user/inscription" class="link-flex-between dropdown-link-right">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "administrateur"): ?>
            <div class="topNav-dropdown-container">
                <button class="dropdown-toggler">
                    <i class="fa-solid fa-user-tie fa-theme topNav-right-icon"></i>
                </button>
                <div class="dropdown-links dropdown-links-right dropdown-links-right-mobile">
                    <a href="/admin/pages/dashboard/" class="link-flex-between dropdown-link-right"><i class="fa-solid fa-pen"></i> Tableau de bord</a>
                    <a href="/admin/security/update/" class="link-flex-between dropdown-link-right"><i class="fa-solid fa-users-viewfinder"></i> Utilisateurs</a>
                </div>
            </div>
        <?php endif; ?>
        <div class="theme-choice">
            <button class="theme-toggler" onclick="toggleTheme()">
                <i class="fa-solid fa-sun topNav-right-icon"></i>
                <i class="fa-solid fa-moon topNav-right-icon"></i>
            </button>
        </div>
    </div>
</header>