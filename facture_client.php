<?php

include'connexion.php';

if (isset($_GET['numclient'])){
    $numclient=$_GET['numclient'];
    
      $record=mysqli_query($con,"select design , pu,qte , pu*qte from client,commande,produit where commande.numproduit=produit.numproduit and client.numclient=commande.numclient and  client.numclient='$numclient'");

                  
      $client=mysqli_query($con,"select *from client where numclient='$numclient'");
      if(mysqli_num_rows($client)==1){
        $cli=mysqli_fetch_array($client);
        $nom=$cli['nom'];
      }
      
      $date1=mysqli_query($con,"select curdate() as datefac");
      $d=mysqli_fetch_array($date1);
      $date=$d['datefac'];
      
      $somme1=mysqli_query($con,"select sum(pu*qte) as somme from client,commande,produit where client.numclient=commande.numclient and produit.numproduit=commande.numproduit and client.numclient='$numclient'");
      $s=mysqli_fetch_array($somme1);
      $somme=$s['somme'];
      
}
?>

<!DOCTYPE html>
    <html>
        <head>
            <title> FACTURE </title>
            <meta charset="utf-8">
            <style>
                body{
                    background-color:grey;
                    color:black;
                }
                h1{
                    font-size:45px;
                }
                
                .form1{
                    text-align:center;
                    border:1px white solid;
                    height:100px;
                    width:850px;
                    margin-left:250px;
                }
                
                input{
                    height:25px;
                    width:200px;
                }
                
                .l3{
                    margin-right:15px;
                }
                
                
            </style>
        </head>
        <body>
            <a href="client.php" style="color:white;">retour</a>
            <center><h1  > F A C T U R E </h1></center>
            
            <form method="POST" action="facture_client.php" class="form1">
                <label class="l1" for="numfac"> Numero facture :</label>
                <input type="text" name="numfac" id="numfac" placeholder="fac/n°...">
                <label class="l2" for="datefac"> Date de facture : </label>
                <input type="date" name="datefac" value="<?=$date ?>" id="datefac"><br/><br/>
                <label class="l3"for="numclient"> Numero du client : </label>
                <input type="text" name="numclient" value="<?=$numclient ?>" id="numclient">
                <label class="l4" for="nom"> nom : </label>
                <input type="text" name="nom" value="<?=$nom ?>" id="nom">
            </form>
            <div>
                <table>
                        <thead>
                            <tr>
                                <th>DESIGNATION</th>
                                <th>PRIX UNITAIRE</th>
                                <th>QUANTITE</th>
                                <th>MONTANT</th>
                            </tr>
                        </thead>
                        <?php while($row =mysqli_fetch_array($record)) { ?>
                        <tr>
                            <td> <?php echo $row['design'] ?> </td>
                            <td> <?php echo $row['pu'] ?> </td>
                            <td> <?php echo $row['qte'] ?> </td>
                            <td> <?php echo $row['pu*qte'] ?> </td>
                        </tr>
                        <?php } ?>
                    </table>
            </div>
            
            <form method="POST" action="facture_client.php">
                <label for="montant_tot">MONTANT TOTAL</label>
                <input type="number" name="montant_tot" value="<?=$somme ?>" id="montant_tot">
            </form>
            
        </body>
    </html>