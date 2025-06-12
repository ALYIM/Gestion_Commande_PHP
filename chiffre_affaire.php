<?php

include'connexion.php';
    
      $record=mysqli_query($con,"select client.numclient,nom,sum(qte*pu) as ca from client,commande,produit where commande.numclient=client.numclient and commande.numproduit=produit.numproduit group by client.numclient;");

      
      $date1=mysqli_query($con,"select year(curdate()) as datechif");
      $d=mysqli_fetch_array($date1);
      $date=$d['datechif'];
      
      $somme1=mysqli_query($con,"select sum(pu*qte) as somme from client,commande,produit where client.numclient=commande.numclient and produit.numproduit=commande.numproduit");
      $s=mysqli_fetch_array($somme1);
      $somme=$s['somme'];
      
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
                
                /*.form1{
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
                }*/
                
                
            </style>
        </head>
        <body>
            <a href="commande.php" style="color:white;">retour</a>
            <center><h1  > CHIFFRE D'AFFAIRE PAR CLIENT </h1></center>
            
            <form method="POST" action="chiffre_affaire.php" class="form1">
                
                <label  for="nom"> Anne : </label>
                <input type="number" name="date" value="<?=$date ?>" id="date">
            </form>
            <div>
                <table>
                        <thead>
                            <tr>
                                <th>NUMERO CLIENT</th>
                                <th>NOM</th>
                                <th>CHIFFRE D'AFFAIRE</th>
                            </tr>
                        </thead>
                        <?php while($row =mysqli_fetch_array($record)) { ?>
                        <tr>
                            <td> <?php echo $row['numclient'] ?> </td>
                            <td> <?php echo $row['nom'] ?> </td>
                            <td> <?php echo $row['ca'] ?> </td>
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