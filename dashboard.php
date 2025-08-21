<?php
// Connexion BDD
$env = parse_ini_file(__DIR__.'/.env');
 
try {
    $pdo = new PDO( 
        "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8",
        $env['DB_USER'],
        $env['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupérer les commandes
    $stmt = $pdo->query("SELECT * FROM commands ORDER BY created_at DESC");
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Stats
    $stats = ['en attente' => 0, 'en preparation' => 0, 'pret' => 0, 'livree' => 0];
    foreach ($commandes as $commande) {
        if (isset($stats[$commande['status']])) {
            $stats[$commande['status']]++;
        }
    }
    
} catch (PDOException $e) {
    die("Erreur DB: " . $e->getMessage());
}

// Traitement du changement de statut
if ($_POST) {
    $commande_id = $_POST['commande_id'];
    $new_status = $_POST['status'];
    
    try {
        $stmt = $pdo->prepare("UPDATE commands SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $commande_id]);
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        die("Erreur update: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Chef - PizzaCreator</title>
    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #2f4858;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f4f6f9;
            color: #333;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--secondary);
            color: white;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-header h1 {
            font-size: 1.5rem;
            color: white;
        }
        
        .sidebar-header p {
            color: #adb5bd;
            font-size: 0.9rem;
        }
        
        .nav-item {
            padding: 12px 20px;
            color: #dee2e6;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .nav-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: inherit
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .en-attente { color: var(--warning); }
        .en-preparation { color: var(--primary); }
        .pret { color: var(--success); }
        .livree { color: var(--secondary); }
        
        /* Commandes */
        .commandes-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .section-header {
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .commandes-list {
            padding: 0;
        }
        
        .commande-item {
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .commande-item:last-child {
            border-bottom: none;
        }
        
        .commande-info h3 {
            margin-bottom: 5px;
        }
        
        .commande-info p {
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .commande-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        .btn-primary { background: var(--primary); color: white; }
        .btn-success { background: var(--success); color: white; }
        .btn-warning { background: var(--warning); color: black; }
        .btn-secondary { background: var(--secondary); color: white; }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-waiting { background: #fff3cd; color: #856404; }
        .badge-preparing { background: #cce5ff; color: #004085; }
        .badge-ready { background: #d4edda; color: #155724; }
        .badge-delivered { background: #e2e3e5; color: #383d41; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 10px 0;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            .commande-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .commande-actions {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>PizzaCreator</h1>
                <p>Dashboard Chef</p>
            </div>
            <div class="nav-item active">
                <i>📋</i> Commandes
            </div>
            <div class="nav-item">
                <i>⏱️</i> En Préparation
            </div>
            <div class="nav-item">
                <i>✅</i> Prêtes à servir
            </div>
            <div class="nav-item">
                <i></i> <a href="index.php?table_id=10">Pizza Creator</a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Commandes en cours</h2>
                <button class="btn btn-primary" onclick="location.reload()">Actualiser</button>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number en-attente"><?= $stats['en attente'] ?></div>
                    <div class="stat-label">En Attente</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number en-preparation"><?= $stats['en preparation'] ?></div>
                    <div class="stat-label">En Préparation</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number pret"><?= $stats['pret'] ?></div>
                    <div class="stat-label">Prêtes à servir</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number livree"><?= $stats['livree'] ?></div>
                    <div class="stat-label">Livrées</div>
                </div>
            </div>

            <div class="commandes-section">
                <div class="section-header">
                    <h3>Toutes les commandes</h3>
                </div>
                <div class="commandes-list">
                    <?php foreach ($commandes as $commande): ?>
                    <div class="commande-item">
                        <div class="commande-info">
                            <h3>Commande #<?= $commande['id'] ?> - Table <?= $commande['table_id'] ?></h3>
                            <p><?= htmlspecialchars($commande['ingredients']) ?></p>
                            <p><strong><?= $commande['total_price'] ?>€</strong> - <?= $commande['created_at'] ?></p>
                        </div>
                        <div class="commande-actions">
                            <span class="status-badge badge-<?= 
                                $commande['status'] == 'en attente' ? 'waiting' : 
                                ($commande['status'] == 'en preparation' ? 'preparing' : 
                                ($commande['status'] == 'pret' ? 'ready' : 'delivered')) 
                            ?>">
                                <?= ucfirst($commande['status']) ?>
                            </span>
                            <form method="POST" style="display: inline">
                                <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                                <input type="hidden" name="status" value="en attente">
                                <button type="submit" class="btn btn-sm btn-warning">En attente</button>
                            </form>
                            <form method="POST" style="display: inline">
                                <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                                <input type="hidden" name="status" value="en preparation">
                                <button type="submit" class="btn btn-sm btn-primary">Préparer</button>
                            </form>
                            <form method="POST" style="display: inline">
                                <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                                <input type="hidden" name="status" value="pret">
                                <button type="submit" class="btn btn-sm btn-success">Prête</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>