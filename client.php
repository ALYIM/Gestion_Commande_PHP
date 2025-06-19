<?php
include 'connexion.php';

// Ajout de client
if(isset($_POST['submit'])) {
    $numero = $_POST['numero'];
    $pseudo = $_POST['pseudo'];
    
    $sql = "INSERT INTO client(numclient, nom) VALUES('$numero', '$pseudo')";
    $result = mysqli_query($con, $sql);
    
    if($result) {
        header('location:client.php?success=1');
    } else {
        die(mysqli_error($con));
    }
}

// Récupération des clients
$clients = [];
$sql = "SELECT * FROM client ORDER BY numclient ASC";
$result = mysqli_query($con, $sql);
if($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $clients[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des Clients | M A R K E T</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
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
        
        .client-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        
        .client-table th {
            background-color: var(--dark-color);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        
        .client-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .client-table tr:last-child td {
            border-bottom: none;
        }
        
        .client-table tr:hover {
            background-color: #f5f9fc;
        }
        
        .client-id {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .action-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .action-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
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
            
            .form-title {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="page-header">
        <div class="logo-container">
            <img src="image/client1.png" alt="Logo Clients">
            <h1 class="page-title">Gestion des Clients</h1>
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
                Client ajouté avec succès!
            </div>
        <?php endif; ?>
        
        <div class="main-layout">
            <!-- Sidebar avec actions -->
            <aside class="sidebar">
                <a href="modifier_client.php" class="action-card">
                    <img src="image/modifier.png" alt="Modifier" class="action-icon">
                    <span class="action-label">Modifier client</span>
                </a>
                
                <a href="supprimer_client.php" class="action-card">
                    <img src="image/supprimer.png" alt="Supprimer" class="action-icon">
                    <span class="action-label">Supprimer client</span>
                </a>
                
                <a href="cherche_client.php" class="action-card">
                    <img src="image/rechercher2.png" alt="Rechercher" class="action-icon">
                    <span class="action-label">Rechercher client</span>
                </a>
            </aside>

            <!-- Contenu principal -->
            <main>
                <!-- Formulaire d'ajout -->
                <section class="form-container">
                    <div class="form-title">
                        <img src="image/ajouter.png" alt="Ajouter">
                        <h2>Ajouter un nouveau client</h2>
                    </div>
                    
                    <form method="post" action="client.php">
                        <div class="form-group">
                            <label for="num">Numéro du client</label>
                            <input type="text" class="form-control" name="numero" id="num" placeholder="Ex: C001" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nom">Nom du client</label>
                            <input type="text" class="form-control" name="pseudo" id="nom" placeholder="Ex: Rakotokoto" required>
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-block">Ajouter le client</button>
                    </form>
                </section>

                <!-- Liste des clients -->
                <section class="table-container">
                    <h2 class="table-title">Liste des clients</h2>
                    <table class="client-table">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom</th>
                                <th>Produits commandés</th>
                                <th>Facture</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($clients) > 0): ?>
                                <?php foreach($clients as $client): ?>
                                    <tr>
                                        <td class="client-id"><?= htmlspecialchars($client['numclient']) ?></td>
                                        <td><?= htmlspecialchars($client['nom']) ?></td>
                                        <td>
                                            <a href="liste_pro_com_cli.php?numclient=<?= $client['numclient'] ?>" class="action-link">
                                                Voir les produits
                                            </a>
                                        </td>
                                        <td>
                                            <a href="facture_client.php?numclient=<?= $client['numclient'] ?>" class="action-link">
                                                Voir la facture
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">Aucun client trouvé</td>
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