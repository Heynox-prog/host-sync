<?php
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../../admin/database/includes/db.php";
session_start();

function generateNumClient()
{
    $parts = [];

    for ($i = 0; $i < 4; $i++) {
        $parts[] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    return implode('-', $parts);
}

function generateNumUnique(PDO $pdo)
{
    do {
        $num_unique = generateNumClient();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id_client = ?");
        $stmt->execute([$num_unique]);
        $count = $stmt->fetchColumn();
    } while ($count > 0);

    return $num_unique;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : "";
    $last_name = isset($_POST['lastname']) ? trim($_POST['lastname']) : "";
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["status-error"] = "L'adresse e-mail n'est pas valide !";
        header("Location: ../../user/inscription");
        exit;
    } elseif ($password !== $password_confirm) {
        $_SESSION["status-error"] = "Les mots de passe ne correspondent pas !";
        header("Location: ../../user/inscription");
        exit;
    } elseif (strlen($password) < 7) {
        $_SESSION["status-error"] = "Le mot de passe doit contenir au minimum 7 caractères !";
        header("Location: ../../user/inscription");
        exit;
    } elseif (strlen($first_name) < 5) {
        $_SESSION["status-error"] = "Le prénom doit contenir au minimum 5 caractères !";
        header("Location: ../../user/inscription");
        exit;
    } else {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $existingUser = $stmt->fetchColumn();

            if ($existingUser > 0) {
                $_SESSION["status-error"] = "Un utilisateur avec cet e-mail existe déjà !";
                header("Location: ../../user/inscription");
                exit;
            } else {
                $default_role = "utilisateur";
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $token = hash("sha256", bin2hex(random_bytes(32)));

                $default_profile_picture = "/static/images/profile/default/default-profile.png";

                $stmt = $pdo->prepare("INSERT INTO users (email, firstname, lastname, password, role, picture, id_client, verified, balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$email, $first_name, $last_name, $hashed_password, $default_role, $default_profile_picture, generateNumUnique($pdo), 0, 0.00]);

                $_SESSION["status-warning"] = "Veuillez vérifier votre e-mail pour activer votre compte !";

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'http://localhost:1025/';
                    $mail->SMTPAuth = false;
                    $mail->Username = 'no-reply@dev-studio.host-sync.com';
                    $mail->Password = 'HostSync2024!';
                    $mail->SMTPSecure = '';
                    $mail->setFrom('no-reply@dev-studio.host-sync.com', 'Host-Sync');
                    $mail->addAddress($email, $first_name, $last_name);
                    $mail->Subject = 'Activation de votre compte | ' . date('Y-m-d H:i:s');
                    $mail->Body = '
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
                    $mail->AltBody = 'Bonjour ' . $first_name . ',\n\nMerci de vous être inscrit sur notre plateforme. Veuillez copier et coller le lien ci-dessous dans votre navigateur pour activer votre compte :\n\nhttp://dev-studio.host-sync.com/activate.php?email=' . $email . '\n\nSi vous n\'êtes pas à l\'origine de cette inscription, vous pouvez ignorer cet e-mail.\n\nCordialement,\nL\'équipe Host-Sync';
                    $mail->isHTML(true);
                    $mail->send();
                } catch (Exception $e) {
                    $_SESSION["status-error"] = "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
                }

                header("Location: ../../user/connexion");
                exit;
            }
        } catch (PDOException $e) {
            echo '<div class="container">Une erreur de connexion: ' . $e->getMessage() . '</div>';
        }
    }
}
