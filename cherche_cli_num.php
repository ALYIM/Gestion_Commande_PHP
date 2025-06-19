<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Recherche Client par Numéro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #006478;
            --secondary-color: #787800;
            --accent-color: maroon;
            --text-light: white;
            --text-dark: black;
            --border-radius: 15px;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: black;
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        .retour1 {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .retour1:hover {
            color: var(--text-light);
            text-decoration: underline;
        }
        
        .container {
            background-color: var(--primary-color);
            border: 2px solid var(--text-light);
            border-radius: var(--border-radius);
            padding: 30px;
            width: 90%;
            max-width: 800px;
            margin-top: 60px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        
        .search-title {
            color: var(--text-light);
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .search-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        
        .search-input {
            padding: 12px 20px;
            border: 1px solid var(--accent-color);
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 300px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 5px var(--secondary-color);
        }
        
        .search-button {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            border: 1px solid var(--text-dark);
            border-radius: var(--border-radius);
            padding: 8px 20px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .search-button:hover {
            background-color: var(--accent-color);
            border-color: var(--secondary-color);
            color: var(--secondary-color);
            font-weight: bold;
            transform: scale(1.05);
        }
        
        .results-container {
            margin-top: 30px;
            width: 100%;
            overflow-x: auto;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        
        .results-table th, 
        .results-table td {
            border: 2px solid var(--text-light);
            padding: 12px 20px;
            text-align: left;
        }
        
        .results-table th {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            font-weight: bold;
        }
        
        .results-table tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .results-table tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .no-results {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2rem;
            color: var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }
            
            .search-title {
                font-size: 1.5rem;
            }
            
            .results-table th, 
            .results-table td {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <a class="retour1" href="client.php">← Retour</a>

    <?php
    // Database connection with error handling
    try {
        $bdd2 = new PDO('mysql:host=localhost;dbname=database;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Initialize variables
        $searchTerm = '';
        $results = [];
        
        // Process search if form submitted
        if(isset($_GET['k']) && !empty($_GET['k'])) {
            $searchTerm = trim($_GET['k']);
            $searchTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
            
            // Use prepared statement to prevent SQL injection
            $query = $bdd2->prepare("SELECT * FROM client WHERE numclient = :numclient");
            $query->bindParam(':numclient', $searchTerm);
            $query->execute();
            $results = $query->fetchAll();
        } else {
            // Get all clients if no search term
            $query = $bdd2->query("SELECT * FROM client");
            $results = $query->fetchAll();
        }
    } catch(PDOException $e) {
        // Log error and display user-friendly message
        error_log("Database error: " . $e->getMessage());
        die("<div class='container'><p class='no-results'>Une erreur est survenue. Veuillez réessayer plus tard.</p></div>");
    }
    ?>

    <div class="container">
        <h1 class="search-title">RECHERCHER UN CLIENT PAR SON NUMÉRO</h1>
        
        <form method="GET" class="search-form">
            <input 
                class="search-input" 
                type="search" 
                name="k" 
                placeholder="Entrez un numéro client..."
                value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            />
            <button type="submit" class="search-button">Valider</button>
        </form>
        
        <div class="results-container">
            <?php if (!empty($results)): ?>
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
                                <td><?= htmlspecialchars($client['numclient'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($client['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif (isset($searchTerm) && $searchTerm !== ''): ?>
                <p class="no-results">Aucun résultat pour "<?= htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') ?>"</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>