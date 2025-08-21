<?php
header('Content-Type: application/json');

// Simuler la connexion DB pour les tests
$isDBAvailable = true; // false pour simuler l'absence de DB

if ($isDBAvailable) {
    // Config DB
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'pizza_restaurant');
    define('DB_USER', 'root');// remettre root avant push
    define('DB_PASS', 'root');

    // Connexion
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur DB: " . $e->getMessage()]);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $table_id = filter_input(INPUT_POST, 'table_id', FILTER_VALIDATE_INT);
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
    $total_price = filter_input(INPUT_POST, 'total_price', FILTER_VALIDATE_FLOAT);

    if (!$table_id || !$ingredients || !$total_price) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    if ($isDBAvailable) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM restaurant_tables WHERE id = ?");
            $stmt->execute([$table_id]);

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(["success" => false, "message" => "Table non trouvée"]);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO commands (table_id, ingredients, total_price, status) VALUES (?, ?, ?, 'en attente')");
            $stmt->execute([$table_id, $ingredients, $total_price]);

            echo json_encode([
                "success" => true,
                "message" => "Commande enregistrée avec succès",
                "command_id" => $pdo->lastInsertId()
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Erreur SQL: " . $e->getMessage()]);
        }
    } else {
        // Simulation sans DB
        echo json_encode([
            "success" => true,
            "message" => "Commande simulée - Table #$table_id: $ingredients - Total: $total_price €",
            "command_id" => rand(1000, 9999)
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}