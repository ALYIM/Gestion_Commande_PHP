<?php
// Inclusion de la connexion
require_once 'connexion.php';

// Initialisation des variables
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];
$message = '';
$hasSearched = false;

// Recherche si un terme a été soumis
if (!empty($q)) {
    $hasSearched = true;
    
    // Préparation de la requête avec protection contre les injections SQL
    $stmt = $con->prepare("SELECT numclient, nom FROM clients WHERE nom LIKE ? ORDER BY nom ASC");
    $searchTerm = '%'.$q.'%';
    $stmt->bind_param('s', $searchTerm);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $results = $result->fetch_all(MYSQLI_ASSOC);
        
        if (empty($results)) {
            $message = "Aucun résultat trouvé pour : " . htmlspecialchars($q);
        }
    } else {
        $message = "Erreur lors de la recherche";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche par nom - Gestion Clients</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --text-color: #333;
            --bg-color: #f9f9f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            padding: 8px 12px;
            border: 1px solid var(--secondary-color);
            border-radius: 4px;
        }

        .back-btn:hover {
            color: white;
            background-color: var(--secondary-color);
        }

        h1 {
            color: var(--dark-color);
            margin-bottom: 20px;
            text-align: center;
            font-size: 2rem;
        }

        .search-form {
            max-width: 600px;
            margin: 0 auto 30px;
            padding: 20px;
            background-color: var(--light-color);
            border-radius: 8px;
        }

        .search-form legend {
            font-weight: bold;
            color: var(--dark-color);
            margin-bottom: 15px;
            font-size: 1.2rem;
            text-align: center;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s;
            margin-bottom: 15px;
        }

        .search-input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .submit-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            width: 100%;
            font-weight: bold;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .results-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .results-table th {
            background-color: var(--dark-color);
            color: white;
            padding: 12px;
            text-align: left;
        }

        .results-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }

        .results-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .results-table tr:hover {
            background-color: #e3f2fd;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            background-color: #fff8e1;
            border-radius: 4px;
            color: var(--accent-color);
            font-weight: 500;
        }

        .results-count {
            text-align: right;
            margin-top: 10px;
            font-style: italic;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .results-table {
                font-size: 0.9rem;
            }

            .results-table th, 
            .results-table td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="cherche_client.php" class="back-btn">
            ← Retour à la recherche
        </a>

        <h1>Recherche par nom</h1>

        <form method="GET" class="search-form">
            <legend>RECHERCHER UN CLIENT PAR SON NOM</legend>
            <input class="search-input" 
                   type="search" 
                   name="q" 
                   placeholder="Entrez le nom du client..." 
                   value="<?php echo htmlspecialchars($q); ?>" 
                   required>
            <input class="submit-btn" type="submit" value="Rechercher">
        </form>

        <?php if (!empty($message)): ?>
            <div class="no-results">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($hasSearched && !empty($results)): ?>
            <div class="results-container">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>NUMÉRO</th>
                            <th>NOM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars($client['numclient']); ?></td>
                            <td><?= htmlspecialchars($client['nom']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="results-count">
                    <?= count($results); ?> résultat(s) trouvé(s)
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php
    // Fermer la connexion (optionnel car PHP le fait automatiquement)
    $con->close();
    ?>
</body>
</html>