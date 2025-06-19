<?php
include 'connexion.php';

// Récupération des données
$record = mysqli_query($con, "SELECT client.numclient, nom, SUM(qte*pu) as ca 
                             FROM client, commande, produit 
                             WHERE commande.numclient = client.numclient 
                             AND commande.numproduit = produit.numproduit 
                             GROUP BY client.numclient");

// Récupération de l'année en cours
$date1 = mysqli_query($con, "SELECT YEAR(CURDATE()) as datechif");
$d = mysqli_fetch_array($date1);
$date = $d['datechif'];

// Calcul du montant total
$somme1 = mysqli_query($con, "SELECT SUM(pu*qte) as somme 
                             FROM client, commande, produit 
                             WHERE client.numclient = commande.numclient 
                             AND produit.numproduit = commande.numproduit");
$s = mysqli_fetch_array($somme1);
$somme = $s['somme'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Chiffre d'Affaire par Client | M A R K E T</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --grey-color: #95a5a6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .back-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .page-title {
            text-align: center;
            color: var(--dark-color);
            margin: 1rem 0 2rem;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        /* Formulaire année */
        .year-form {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .form-group {
            display: inline-block;
            margin: 0 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-control {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            text-align: center;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        /* Tableau */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            margin-bottom: 2rem;
            overflow-x: auto;
        }
        
        .ca-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        
        .ca-table th {
            background-color: var(--dark-color);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        
        .ca-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .ca-table tr:last-child td {
            border-bottom: none;
        }
        
        .ca-table tr:hover {
            background-color: #f5f9fc;
        }
        
        .client-id {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .ca-amount {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        /* Total */
        .total-container {
            background-color: var(--dark-color);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 2rem;
        }
        
        .total-label {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .form-group {
                display: block;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <a href="commande.php" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Retour aux commandes
            </a>
        </div>
        
        <h1 class="page-title">CHIFFRE D'AFFAIRE PAR CLIENT</h1>
        
        <form method="POST" action="chiffre_affaire.php" class="year-form">
            <div class="form-group">
                <label for="date">Année</label>
                <input type="number" class="form-control" name="date" value="<?= $date ?>" id="date" min="2000" max="2100">
            </div>
        </form>
        
        <div class="table-container">
            <table class="ca-table">
                <thead>
                    <tr>
                        <th>CLIENT</th>
                        <th>NOM</th>
                        <th>CHIFFRE D'AFFAIRE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($record)): ?>
                    <tr>
                        <td class="client-id"><?= htmlspecialchars($row['numclient']) ?></td>
                        <td><?= htmlspecialchars($row['nom']) ?></td>
                        <td class="ca-amount"><?= number_format($row['ca'], 0, ',', ' ') ?> Fmg</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div class="total-container">
            <div class="total-label">MONTANT TOTAL</div>
            <div class="total-amount"><?= number_format($somme, 0, ',', ' ') ?> Fmg</div>
        </div>
    </div>
</body>
</html>