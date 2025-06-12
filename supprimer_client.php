<?php

include 'connexion.php';
if(isset($_GET['delete'])){
    $numclient=$_GET['numero'];
    
    $sql="delete from client where numclient='$numclient'";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:client.php');
    }else{
        die(mysqli_error($con));
    }
}

?>


<!DOCTYPE html>
    <html>
        <head>
            <title>SUPPRIMER DES CLIENT</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="supprimer_client.css"/>
        </head>
        <body>
             <a class="retour1" href="client.php">Retour</a>
            
            <form class="form1" methode="post" action="supprimer_client.php">
                <legend> SUPPRIMER UN SEUL CLIENT </legend>
                <label for="num"> Entrer le numero a supprimer </label><br/>
                <input class="input1" type="text" name="numero" id="num"><br/><br/>
                <input class="input2" name="delete" type="submit" value="supprimer">
            
            </form>
            
        </body>
    </html>