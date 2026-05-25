<?php

function slug(string $text): string {
    if (class_exists('Transliterator')) {
        $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
        $text = $transliterator->transliterate($text);
    } else {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    }

    $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);

    return strtolower(trim($text, '-'));
}

/* Get user information from session */
function getUserMail() { return $_SESSION['user_email'] ?? null; }
function getUserFirstName() { return $_SESSION['user_firstname'] ?? null; }
function getUserLastName() { return $_SESSION['user_lastname'] ?? null; }
function getUserRole() { return $_SESSION['user_role'] ?? null; }
function getUserBalance($pdo) {
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['balance'] : null;
    }
    return 0.00;
}

/* Get services informations */
function getServicesCount(PDO $pdo): int {
    $stmt = $pdo->query("SELECT COUNT(*) FROM services");
    return (int) $stmt->fetchColumn();
}
function getServices(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM services");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Get articles informations */
function getArticlesCount(PDO $pdo): int {
    $stmt = $pdo->query("SELECT COUNT(*) FROM articles");
    return (int) $stmt->fetchColumn();
}
function getArticlesLimit(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM articles LIMIT 6");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllArticles(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM articles");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Generate a unique token */
function generateUniqueToken(PDO $pdo): string {
    do {
        $token = bin2hex(random_bytes(32));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_tokens WHERE token = ?");
        $stmt->execute([$token]);
    } while ($stmt->fetchColumn() > 0);

    return $token;
}