<?php
include 'connexion.php';

// Ajout de produit
if(isset($_POST['submit'])) {
    $numproduit = $_POST['numproduit'];
    $design = $_POST['design'];
    $pu = $_POST['pu'];
    $stock = $_POST['stock'];
    
    $sql = "INSERT INTO produit(numproduit, design, pu, stock) VALUES('$numproduit', '$design', '$pu', '$stock')";
    $result = mysqli_query($con, $sql);
    
    if($result) {
        header('location:produit.php');
    } else {
        die(mysqli_error($con));
    }
}

// Récupération des produits
$produits = [];
$sql = "SELECT * FROM produit ORDER BY numproduit ASC";
$result = mysqli_query($con, $sql);
if($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $produits[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des Produits | M A R K E T</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color:rgb(27, 24, 20);
            --warning-color:rgb(27, 24, 20);
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-color);
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .page-header {
            background-color: var(--dark-color);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-container img {
            width: 50px;
            height: auto;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .back-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--primary-color);
        }
        
        /* Layout principal */
        .main-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }
        
        /* Sidebar */
        .sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: fit-content;
        }
        
        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s;
            padding: 1rem;
            border-radius: 8px;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: var(--light-color);
        }
        
        .action-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 0.5rem;
            object-fit: contain;
        }
        
        .action-label {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Formulaire */
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .form-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }
        
        .form-title img {
            width: 40px;
            height: 40px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        /* Tableau */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            overflow-x: auto;
        }
        
        .table-title {
            margin-bottom: 1rem;
            color: var(--dark-color);
            font-size: 1.25rem;
        }
        
        .product-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        
        .product-table th {
            background-color: var(--dark-color);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        
        .product-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .product-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-table tr:hover {
            background-color: #f5f9fc;
        }
        
        .product-id {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .product-price {
            color: var(--danger-color);
            font-weight: 600;
        }
        
        .stock-high {
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        .stock-medium {
            color: var(--warning-color);
            font-weight: 600;
        }
        
        .stock-low {
            color: var(--danger-color);
            font-weight: 600;
        }
        
        /* Alertes */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .action-card {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .sidebar {
                grid-template-columns: 1fr;
            }
            
            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="page-header">
        <div class="logo-container">
            <img src="image/market1.png" alt="Logo Market">
            <h1 class="page-title">Gestion des Produits</h1>
        </div>
        <a href="acceuil.php" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Retour à l'accueil
        </a>
    </header>

    <div class="container">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Produit ajouté avec succès!
            </div>
        <?php endif; ?>
        
        <div class="main-layout">
            <!-- Sidebar avec actions -->
            <aside class="sidebar">
                <a href="modifier_produit.php" class="action-card">
                    <img src="image/modifier.png" alt="Modifier" class="action-icon">
                    <span class="action-label">Modifier produit</span>
                </a>
                
                <a href="supprimer_produit.php" class="action-card">
                    <img src="image/supprimer.png" alt="Supprimer" class="action-icon">
                    <span class="action-label">Supprimer produit</span>
                </a>
                
                <a href="cherche_produit.php" class="action-card">
                    <img src="image/rechercher2.png" alt="Rechercher" class="action-icon">
                    <span class="action-label">Rechercher produit</span>
                </a>
            </aside>

            <!-- Contenu principal -->
            <main>
                <!-- Formulaire d'ajout -->
                <section class="form-container">
                    <div class="form-title">
                        <img src="image/ajouter.png" alt="Ajouter">
                        <h2>Ajouter un nouveau produit</h2>
                    </div>
                    
                    <form method="post" action="produit.php">
                        <div class="form-group">
                            <label for="num">Numéro du produit</label>
                            <input type="text" class="form-control" name="numproduit" id="num" placeholder="Ex: P001" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nom">Désignation</label>
                            <input type="text" class="form-control" name="design" id="nom" placeholder="Ex: Banane" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="pu">Prix unitaire (Fmg)</label>
                            <input type="number" class="form-control" name="pu" id="pu" placeholder="Ex: 100055" required min="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Stock disponible</label>
                            <input type="number" class="form-control" name="stock" id="stock" placeholder="Ex: 102" required min="0">
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-block">Ajouter le produit</button>
                    </form>
                </section>

                <!-- Liste des produits -->
                <section class="table-container">
                    <h2 class="table-title">Liste des produits</h2>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Désignation</th>
                                <th>Prix unitaire</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($produits) > 0): ?>
                                <?php foreach($produits as $produit): 
                                    $stockClass = '';
                                    if($produit['stock'] > 20) {
                                        $stockClass = 'stock-high';
                                    } elseif($produit['stock'] > 10) {
                                        $stockClass = 'stock-medium';
                                    } else {
                                        $stockClass = 'stock-low';
                                    }
                                ?>
                                    <tr>
                                        <td class="product-id"><?= htmlspecialchars($produit['numproduit']) ?></td>
                                        <td><?= htmlspecialchars($produit['design']) ?></td>
                                        <td class="product-price"><?= number_format($produit['pu'], 0, ',', ' ') ?> Fmg</td>
                                        <td class="<?= $stockClass ?>"><?= htmlspecialchars($produit['stock']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">Aucun produit trouvé</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>
</body>
</html>