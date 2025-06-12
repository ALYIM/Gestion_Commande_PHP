<?php

include 'connexion.php';
if(isset($_GET['delete'])){
    $numclient=$_GET['numclient'];
    $numproduit=$_GET['numproduit'];
    
    $q="select qte from commande where numclient='$numclient' and numproduit='$numproduit'";
    $r=mysqli_query($con,$q);
    $row=mysqli_fetch_array($r);
    $qte=$row['qte'];
    
    $sql="delete from commande where numclient='$numclient' and numproduit='$numproduit'";
    $result=mysqli_query($con,$sql);
    
    if($result){
        $csql="update produit,commande set produit.stock=produit.stock+$qte where produit.numproduit='$numproduit'";
        $con->query($csql);
         header('location:commande.php');
    }else{
        die(mysqli_error($con));
    }
}

?>


<!DOCTYPE html>
    <html>
        <head>
            <title>SUPPRIMER DES COMMANDES</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="supprimer_commande.css"/>
        </head>
        <body>
             <a class="retour1" href="commande.php">Retour</a>
            
            <form class="form1" methode="post" action="supprimer_commande.php">
                <legend> SUPPRIMER UN SEUL PRODUIT </legend>
                <label for="num"> Entrer le numero de client a supprimer </label><br/>
                <input class="input1" type="text" name="numclient" id="num"><br/><br/>
                <label for="num"> Entrer le numero de produit a supprimer </label><br/>
                <input class="input1" type="text" name="numproduit" id="num"><br/><br/>
                <input class="input2" name="delete" type="submit" value="supprimer">
            
            </form>
            
        </body>
    </html>