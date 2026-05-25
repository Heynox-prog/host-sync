<?php
$search = $_GET['q'] ?? '';

if ($search !==  "") {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE firstname LIKE :search OR email LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) {
        $_SESSION["user_notFound"] = "Aucun utilisateur trouvé !";
        header("");
    }
} else {
    $stmt = $pdo->prepare("SELECT id, firstname, email, role FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>