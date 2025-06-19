<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un client</title>
    <style>
        :root {
            --primary-color: #006478;
            --secondary-color: #ff4757;
            --text-color: #ffffff;
            --bg-color: #121212;
            --hover-color: #0088a9;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .container {
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            width: 90%;
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .back-btn:hover {
            color: #ff6b81;
        }
        
        h1 {
            margin-bottom: 2rem;
            color: var(--secondary-color);
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .options-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .or-separator {
            display: flex;
            align-items: center;
            color: var(--text-color);
            margin: 1rem 0;
        }
        
        .or-separator::before,
        .or-separator::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--secondary-color);
            margin: 0 1rem;
        }
        
        .search-option {
            display: inline-block;
            padding: 1.2rem 3rem;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border: 2px solid var(--secondary-color);
            border-radius: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            text-align: center;
            min-width: 250px;
        }
        
        .search-option:hover {
            background-color: var(--hover-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }
            
            .search-option {
                padding: 1rem 2rem;
                font-size: 1rem;
                min-width: 200px;
            }
        }
    </style>
</head>
<body>
    <a href="client.php" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
        Retour
    </a>
    
    <div class="container">
        <h1>Rechercher un client</h1>
        
        <div class="options-container">
            <a href="cherche_cli_nom.php" class="search-option">Chercher par nom</a>
            
            <div class="or-separator">OU</div>
            
            <a href="cherche_cli_num.php" class="search-option">Chercher par numéro</a>
        </div>
    </div>
</body>
</html>