<?php

include 'connexion.php';
if(isset($_GET['delete'])){
    $numproduit=$_GET['numproduit'];
    $design=$_GET['design'];
    $npu=$_GET['pu'];
    $stock=$_GET['stock'];
    
    $sql="delete from produit where numproduit='$numproduit'";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:produit.php');
    }else{
        die(mysqli_error($con));
    }
}

?>


<!DOCTYPE html>
    <html>
        <head>
            <title>SUPPRIMER DES PROSUITS</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="supprimer_produit.css"/>
        </head>
        <body>
             <a class="retour1" href="produit.php">Retour</a>
            
            <form class="form1" methode="post" action="supprimer_produit.php">
                <legend> SUPPRIMER UN SEUL PRODUIT </legend>
                <label for="num"> Entrer le numero a supprimer </label><br/>
                <input class="input1" type="text" name="numproduit" id="num"><br/><br/>
                <input class="input2" name="delete" type="submit" value="supprimer">
            
            </form>
            
        </body>
    </html>