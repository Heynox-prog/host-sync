<?php
require "./user/functions/create_user.php";

$mailBody = '
    <html>
    <head>
        <title>Activation de votre compte</title>

        <style>
            body {
                display: flex;
                justify-content: center;
                width: 100%;
            }

            .container {
                max-width: 600px;
                padding: 25px;
                border: 1px solid #ddd;
                border-radius: 8px;
            }

            .header {
                margin-bottom: 20px;
                border-bottom: 1px solid #ddd;
            }

            .title, .welcome {
                text-align: center;
            }

            .footer {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="title">
                    <h1>Activation de votre compte Host-Sync</h1>
                </div>
                <div class="welcome">
                    <h3 style="font-size: 22px;">Bonjour, ' . htmlspecialchars($first_name) . ' !</h3>
                    <p>Merci de vous être inscrit sur notre plateforme. Pour pouvoir utiliser toutes les fonctionnalités, veuillez activer votre compte en cliquant sur le bouton ci-dessous.
                </div>
            </div>
            <div class="body">
                <p>Si vous appuyez sur le bouton "Activer mon compte", vous acceptez en même temps nos Conditions Générales d\'Utilisation et notre Politique de Confidentialité.</p>
                <p>Si vous n\'êtes pas à l\'origine de cette inscription, vous pouvez ignorer cet e-mail.</p>
            </div>
            <div class="footer">
                <a href="http://dev-studio.host-sync.com/activate.php?token=' . urlencode($token) . '" style="display: inline-block; padding: 10px 20px; background-color: #1a73e8; color: #fff; text-decoration: none; border-radius: 5px;">Activer mon compte</a>
            </div>
        </div>
    </body>
    </html>
';
