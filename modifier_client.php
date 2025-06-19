<?php
// Connexion à la base de données
$connection = mysqli_connect("localhost", "root", "", "projet2");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Traitement de la mise à jour
if(isset($_POST['update'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $nom = mysqli_real_escape_string($connection, $_POST['nom']);
    
    // Vérification si le client existe
    $check_query = "SELECT * FROM client WHERE numclient='$id'";
    $check_result = mysqli_query($connection, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Mise à jour des données
        $query = "UPDATE client SET nom='$nom' WHERE numclient='$id'";
        
        if(mysqli_query($connection, $query)) {
            $message = "Client mis à jour avec succès";
            $alert_class = "alert-success";
        } else {
            $message = "Erreur lors de la mise à jour: " . mysqli_error($connection);
            $alert_class = "alert-danger";
        }
    } else {
        $message = "Client non trouvé";
        $alert_class = "alert-warning";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mise à jour Client</title>
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
        }
        
        .update-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .header-title {
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 30px;
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
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-update {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-update:hover {
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
        
        .client-search {
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .update-container {
                padding: 20px;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="update-container">
            <a href="client.php" class="btn-back d-inline-flex align-items-center mb-3">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
            
            <h1 class="header-title">Modification Client</h1>
            
            <?php if(isset($message)): ?>
                <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form action="modifier_client.php" method="POST">
                <div class="mb-4">
                    <label for="id" class="form-label">Numéro client</label>
                    <input type="text" class="form-control" id="id" name="id" 
                           placeholder="Entrez le numéro du client" required>
                </div>
                
                <div class="mb-4">
                    <label for="nom" class="form-label">Nouveau nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" 
                           placeholder="Entrez le nouveau nom" required>
                </div>
                
                <button type="submit" name="update" class="btn btn-update">
                    <i class="fas fa-save me-2"></i> Mettre à jour
                </button>
            </form>
            
            <!-- Section pour la recherche interactive (optionnelle) -->
            <div class="client-search mt-5">
                <h5><i class="fas fa-search me-2"></i>Rechercher un client</h5>
                <input type="text" class="form-control" id="searchClient" 
                       placeholder="Commencez à taper un nom...">
                <div id="clientResults" class="mt-2"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Recherche interactive des clients
        document.getElementById('searchClient').addEventListener('input', function() {
            const searchTerm = this.value;
            if(searchTerm.length > 2) {
                fetch('search_client.php?term=' + encodeURIComponent(searchTerm))
                    .then(response => response.json())
                    .then(data => {
                        const resultsContainer = document.getElementById('clientResults');
                        resultsContainer.innerHTML = '';
                        
                        if(data.length > 0) {
                            const list = document.createElement('ul');
                            list.className = 'list-group';
                            
                            data.forEach(client => {
                                const item = document.createElement('li');
                                item.className = 'list-group-item list-group-item-action';
                                item.innerHTML = `
                                    <strong>${client.numclient}</strong> - ${client.nom}
                                    <button class="btn btn-sm btn-outline-primary float-end" 
                                            onclick="fillForm('${client.numclient}', '${client.nom.replace(/'/g, "\\'")}')">
                                        Sélectionner
                                    </button>
                                `;
                                list.appendChild(item);
                            });
                            
                            resultsContainer.appendChild(list);
                        } else {
                            resultsContainer.innerHTML = '<div class="alert alert-info">Aucun client trouvé</div>';
                        }
                    });
            }
        });
        
        // Remplissage automatique du formulaire
        function fillForm(id, nom) {
            document.getElementById('id').value = id;
            document.getElementById('nom').value = nom;
            document.getElementById('clientResults').innerHTML = '';
            document.getElementById('searchClient').value = '';
        }
        
        // Animation du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach((input, index) => {
                setTimeout(() => {
                    input.style.opacity = '1';
                    input.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>