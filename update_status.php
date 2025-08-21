<?php
header('Content-Type: application/json');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'pizza_restaurant');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur DB: " . $e->getMessage()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données
    $data = json_decode(file_get_contents("php://input"), true);
    $commande_id = filter_var($data['commande_id'], FILTER_VALIDATE_INT);
    $status = filter_var($data['status'], FILTER_SANITIZE_STRING);

    if (!$commande_id || !$status) {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    // Statuts valides
    $validStatuses = ['en attente', 'en preparation', 'pret', 'livree'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(["success" => false, "message" => "Statut invalide"]);
        exit;
    }

    try {
        // Mettre à jour le statut
        $stmt = $pdo->prepare("UPDATE commands SET status = ? WHERE id = ?");
        $stmt->execute([$status, $commande_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Statut mis à jour"]);
        } else {
            echo json_encode(["success" => false, "message" => "Commande non trouvée"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur SQL: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
