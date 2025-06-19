<?php
include 'connexion.php';

// Sécurisation des données et vérifications
if (isset($_GET['numclient'])) {
    $numclient = mysqli_real_escape_string($con, $_GET['numclient']);
    
    // Requête pour les produits commandés
    $record = mysqli_query($con, "SELECT design, pu, qte, pu*qte AS total 
                                 FROM client, commande, produit 
                                 WHERE commande.numproduit = produit.numproduit 
                                 AND client.numclient = commande.numclient 
                                 AND client.numclient = '$numclient'");

    // Informations client
    $client = mysqli_query($con, "SELECT * FROM client WHERE numclient = '$numclient'");
    if(mysqli_num_rows($client) == 1) {
        $cli = mysqli_fetch_array($client);
        $nom = htmlspecialchars($cli['nom']);
        $adresse = htmlspecialchars($cli['adresse'] ?? '');
        $telephone = htmlspecialchars($cli['telephone'] ?? '');
    }
    
    // Date de facture
    $date1 = mysqli_query($con, "SELECT CURDATE() AS datefac");
    $d = mysqli_fetch_array($date1);
    $date = $d['datefac'];
    
    // Calcul du total
    $somme1 = mysqli_query($con, "SELECT SUM(pu*qte) AS somme 
                                 FROM client, commande, produit 
                                 WHERE client.numclient = commande.numclient 
                                 AND produit.numproduit = commande.numproduit 
                                 AND client.numclient = '$numclient'");
    $s = mysqli_fetch_array($somme1);
    $somme = number_format($s['somme'] ?? 0, 2, ',', ' ');
    
    // Génération automatique du numéro de facture
    $num_facture = "FAC-" . date('Ymd') . "-" . str_pad($numclient, 4, '0', STR_PAD_LEFT);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Facture Client</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
        }
        
        .invoice-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .invoice-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .invoice-title {
            color: var(--secondary-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .company-info {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .client-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .invoice-table {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-table thead th {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }
        
        .invoice-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .invoice-table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .total-section {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: 8px;
            text-align: right;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .btn-print {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-print:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .text-bold {
            font-weight: 700;
        }
        
        @media print {
            body {
                background-color: white;
            }
            
            .invoice-container {
                box-shadow: none;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header text-center mb-4">
            <h1 class="invoice-title">Facture</h1>
            <a href="client.php" class="btn btn-outline-primary no-print mb-3">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="company-info">
                    <h4 class="text-primary mb-3">Chez Evah</h4>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Andrefantsena, IHOSY</p>
                    <p><i class="fas fa-phone me-2"></i> +123 456 7890</p>
                    <p><i class="fas fa-envelope me-2"></i> contact@votreentreprise.com</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="client-info">
                    <h4 class="text-primary mb-3">INFORMATIONS CLIENT</h4>
                    <p><span class="text-bold">Numéro:</span> <?= htmlspecialchars($numclient) ?></p>
                    <p><span class="text-bold">Nom:</span> <?= $nom ?></p>
                    <?php if(!empty($adresse)): ?>
                        <p><span class="text-bold">Adresse:</span> <?= $adresse ?></p>
                    <?php endif; ?>
                    <?php if(!empty($telephone)): ?>
                        <p><span class="text-bold">Téléphone:</span> <?= $telephone ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-bold">Numéro de facture</label>
                    <input type="text" class="form-control" value="<?= $num_facture ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-bold">Date de facture</label>
                    <input type="date" class="form-control" value="<?= $date ?>" readonly>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="invoice-table table">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($record) > 0): ?>
                        <?php while($row = mysqli_fetch_array($record)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['design']) ?></td>
                                <td><?= number_format($row['pu'], 2, ',', ' ') ?> AR</td>
                                <td><?= htmlspecialchars($row['qte']) ?></td>
                                <td><?= number_format($row['total'], 2, ',', ' ') ?> AR</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">Aucun produit trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="total-section">
            <div class="row">
                <div class="col-md-8 text-end">
                    <p class="mb-2">Sous-total:</p>
                    <p class="mb-2">TVA (20%):</p>
                    <p class="text-bold">Montant Total:</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-2"><?= number_format($s['somme'] * 0.8, 2, ',', ' ') ?> AR</p>
                    <p class="mb-2"><?= number_format($s['somme'] * 0.2, 2, ',', ' ') ?> AR</p>
                    <p class="text-bold"><?= $somme ?> AR</p>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center no-print">
            <button class="btn-print" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimer la facture
            </button>
        </div>
        
        <div class="mt-5 pt-4 border-top text-center">
            <p>Merci pour votre confiance !</p>
            <p class="text-muted">Pour toute question, contactez-nous à ralahyisaorymialy@gmail.com</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Génération automatique du numéro de facture si vide
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des lignes du tableau
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '1';
                }, index * 100);
            });
            
            // Calcul automatique du total si modification des quantités
            const quantityInputs = document.querySelectorAll('input[name="qte[]"]');
            if(quantityInputs.length > 0) {
                quantityInputs.forEach(input => {
                    input.addEventListener('change', updateTotals);
                });
            }
        });
        
        function updateTotals() {
            // Fonction pour mettre à jour les totaux si modification interactive
            console.log('Mise à jour des totaux...');
            // Implémentez la logique de recalcul ici si nécessaire
        }
    </script>
</body>
</html>