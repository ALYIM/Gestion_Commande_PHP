<?php

$con = new mysqli('localhost', 'root', '', 'database');

// Vérification de la connexion
if ($con->connect_error) {
    die("Échec de la connexion : " . $con->connect_error);
}

// Pas de message si la connexion est réussie
?>
