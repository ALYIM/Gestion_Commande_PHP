<?php 
include 'connexion.php';

// Vérification et sécurisation des données POST
$numcli = isset($_POST['num_cli']) ? mysqli_real_escape_string($con, $_POST['num_cli']) : '';
$nomcli = isset($_POST['nom_cli']) ? mysqli_real_escape_string($con, $_POST['nom_cli']) : '';
$datemin = isset($_POST['datemin']) ? $_POST['datemin'] : '';
$datemax = isset($_POST['datemax']) ? $_POST['datemax'] : '';

// Requête sécurisée avec préparation des dates
if(!empty($numcli) && !empty($datemin) && !empty($datemax)) {
    $query = "SELECT produit.* FROM client, produit, commande 
              WHERE commande.numclient = client.numclient 
              AND commande.numproduit = produit.numproduit 
              AND client.numclient = '$numcli' 
              AND commande.date BETWEEN '$datemin' AND '$datemax'";
    
    $recherche = mysqli_query($con, $query);
} else {
    $recherche = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des produits commandés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .header-title {
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }
        
        .header-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary-color);
        }
        
        .client-info-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-back {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            color: var(--primary-color);
            transform: translateX(-3px);
        }
        
        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 15px;
            text-align: center;
        }
        
        .table tbody tr {
            transition: all 0.3s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.1);
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #eee;
        }
        
        .no-products {
            text-align: center;
            padding: 30px;
            color: #777;
            font-style: italic;
        }
        
        .date-range-info {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 5px 5px 0;
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 20px;
            }
            
            .client-info-card {
                padding: 15px;
            }
            
            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-container">
            <a href="client.php" class="btn-back mb-3 d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
            
            <h1 class="header-title">Liste des produits commandés</h1>
            
            <?php if(!empty($datemin) && !empty($datemax)): ?>
                <div class="date-range-info">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Période sélectionnée</h5>
                    <p class="mb-0">Du <strong><?= htmlspecialchars($datemin) ?></strong> au <strong><?= htmlspecialchars($datemax) ?></strong></p>
                </div>
            <?php endif; ?>
            
            <div class="card client-info-card mb-4">
                <div class="card-body">
                    <form action="liste_pro_com_clie.php" method="POST" class="row g-3">
                        <div class="col-md-6">
                            <label for="num" class="form-label">Numéro client</label>
                            <input type="text" class="form-control" name="num_cli" value="<?= htmlspecialchars($numcli) ?>" id="num" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom_cli" value="<?= htmlspecialchars($nomcli) ?>" id="nom" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="jour1" class="form-label">Date de début</label>
                            <input type="date" class="form-control" name="datemin" value="<?= htmlspecialchars($datemin) ?>" id="jour1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jour2" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" name="datemax" value="<?= htmlspecialchars($datemax) ?>" id="jour2" required>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Filtrer les produits
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="table-container">
                <?php if($recherche && mysqli_num_rows($recherche) > 0): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Désignation</th>
                                <th>Prix unitaire</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($recherche)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['numproduit']) ?></td>
                                    <td><?= htmlspecialchars($row['design']) ?></td>
                                    <td><?= number_format($row['pu'], 2, ',', ' ') ?> €</td>
                                    <td>
                                        <span class="badge bg-<?= ($row['stock'] > 0) ? 'success' : 'danger' ?>">
                                            <?= htmlspecialchars($row['stock']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary ms-1">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php elseif($recherche): ?>
                    <div class="no-products">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <h5>Aucun produit commandé trouvé</h5>
                        <p class="text-muted">Aucun produit n'a été commandé par ce client dans la période sélectionnée.</p>
                    </div>
                <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <h5>Sélectionnez une période</h5>
                        <p class="text-muted">Veuillez sélectionner une plage de dates pour afficher les produits commandés.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validation des dates avant soumission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if(form) {
                form.addEventListener('submit', function(e) {
                    const dateDebut = document.getElementById('jour1').value;
                    const dateFin = document.getElementById('jour2').value;
                    
                    if(dateDebut && dateFin && dateDebut > dateFin) {
                        alert('La date de fin doit être postérieure à la date de début');
                        e.preventDefault();
                        return false;
                    }
                    
                    // Feedback visuel pendant le chargement
                    const btn = this.querySelector('button[type="submit"]');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Traitement...';
                    btn.disabled = true;
                });
            }
            
            // Animation des lignes du tableau
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '1';
                }, index * 100);
            });
        });
    </script>
</body>
</html>