<?php
include 'connexion.php';

// Vérification et sécurisation de la suppression
if(isset($_POST['delete'])) {
    $numclient = mysqli_real_escape_string($con, $_POST['numero']);
    
    // Vérification que le client existe avant suppression
    $check_sql = "SELECT * FROM client WHERE numclient='$numclient'";
    $check_result = mysqli_query($con, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Suppression avec confirmation
        $sql = "DELETE FROM client WHERE numclient='$numclient'";
        $result = mysqli_query($con, $sql);
        
        if($result) {
            $_SESSION['message'] = "Client supprimé avec succès";
            $_SESSION['message_type'] = "success";
            header('Location: client.php');
            exit();
        } else {
            $error = "Erreur lors de la suppression: " . mysqli_error($con);
        }
    } else {
        $error = "Client non trouvé";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Suppression Client</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e74c3c;
            --secondary-color: #2c3e50;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .delete-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .header-title {
            color: var(--primary-color);
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
            box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25);
        }
        
        .btn-delete {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-delete:hover {
            background-color: #c0392b;
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
        
        .confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .confirmation-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .delete-container {
                padding: 20px;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="delete-container">
            <a href="client.php" class="btn-back d-inline-flex align-items-center mb-3">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
            
            <h1 class="header-title">Suppression Client</h1>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form id="deleteForm" method="POST" action="supprimer_client.php">
                <div class="mb-4">
                    <label for="numero" class="form-label">Numéro client à supprimer</label>
                    <input type="text" class="form-control" id="numero" name="numero" 
                           placeholder="Entrez le numéro du client" required>
                </div>
                
                <button type="button" class="btn btn-delete" onclick="showConfirmation()">
                    <i class="fas fa-trash-alt me-2"></i> Supprimer
                </button>
            </form>
            
            <!-- Section pour la recherche interactive -->
            <div class="client-search mt-5">
                <h5><i class="fas fa-search me-2"></i>Rechercher un client</h5>
                <input type="text" class="form-control" id="searchClient" 
                       placeholder="Commencez à taper un numéro ou nom...">
                <div id="clientResults" class="mt-2"></div>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmation -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-box">
            <h3><i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirmation</h3>
            <p class="my-4">Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-secondary" onclick="hideConfirmation()">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-check me-2"></i>Confirmer
                </button>
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
                                    <button class="btn btn-sm btn-outline-danger float-end" 
                                            onclick="selectClient('${client.numclient}')">
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
        
        // Sélection d'un client depuis les résultats
        function selectClient(numclient) {
            document.getElementById('numero').value = numclient;
            document.getElementById('clientResults').innerHTML = '';
            document.getElementById('searchClient').value = '';
        }
        
        // Affichage de la modal de confirmation
        function showConfirmation() {
            if(document.getElementById('numero').value.trim() !== '') {
                document.getElementById('confirmationModal').style.display = 'flex';
            } else {
                alert('Veuillez entrer un numéro de client');
            }
        }
        
        // Masquage de la modal
        function hideConfirmation() {
            document.getElementById('confirmationModal').style.display = 'none';
        }
        
        // Confirmation de suppression
        function confirmDelete() {
            document.getElementById('deleteForm').submit();
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