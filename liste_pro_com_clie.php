<?php include ('connexion.php')?>

<!DOCTYPE html>
    <html>
        <head>
            <title> Liste des produit commandé </title>
            <meta charset="utf-8">
            <style>
            body{
                   background-color:whitesmoke;
                }
                
            legend{
                color:white;
                font-size:20px;
            }
            
            .input1{
                border:1px black solid;
                height:20px;
                width:150px;
                border-radius:10px;
                margin:2px;
            }
            .input2{
                border:1px black solid;
                height:20px;
                width:150px;
                border-radius:10px;
                margin:2px;
            }
            
            .input3{
                border:1px black solid;
                height:20px;
                width:150px;
                border-radius:10px;
                margin:2px;
            }
            .input4{
                border:1px black solid;
                height:20px;
                width:150px;
                border-radius:10px;
                margin:2px;
            }
            
            .i11{
                margin-left:10px;
            }
            .i22{
                margin-left:70px;
            }
            .i33{
                margin-left:30px;
            }
            .i44{
                margin-left:50px;
            }
                

           #divbody{
                  background-color:black;
                  border :5px white double;
                  border-radius: 15px;
                  color : white;
                  height : 420pt;
                  width : 950pt;
                  position: relative;
                  top : 35px;
                  left : 35px;
               }
               
            .bloc1{
                border : 1px white solid;
                background-color:rgb(0,100,120);
                border-radius:10px;
                width:300px;
                height:150px;
                margin-left:450px;
               }
            
            .button{
                margin-left:40px;
                margin-top:10px;
            }
            
            .affichage{
                border:1px white solid;
                border-radius:15px;
                height:300px;
                width:715pt;
                margin-left:150px;
                margin-top:10px;
            }
            
            table{
                border-collapse:collapse;
                color:white;
            }
            
            th,td{
                border:1px white solid;
            }
            
            
            </style>
        </head>
        <body>
            <a href="client.php"> retour </a>
            
            <?php
            
             $numcli=$_POST['num_cli'];
             $nomcli=$_POST['nom_cli'];
             $datemin=$_POST['datemin'];
             $datemax=$_POST['datemax'];
             
             $recherche=mysqli_query($con,"SELECT produit.* FROM client,produit,commande WHERE commande.numclient=client.numclient and commande.numproduit=produit.numproduit and client.numclient='$numcli' and commande.date between '$datemin' and '$datemax'");
                          
            ?>
            
            <div id="divbody">
                <center><h1>Liste des produits commandé entre 2 dates</h1></center>
    
                    <form class="bloc1" action="liste_pro_com_clie.php" method="POST">
                        <label class="i11" for="num">Numero client :</label>
                        <input class="input1" type="text" name="num_cli" value="<?= $numcli ?>"id="num" ></br>
                        <label class="i22" for="nom">Nom :</label>
                        <input class="input2" type="text" name="nom_cli" value="<?= $nomcli ?>" id="nom" ></br>
                        <label class="i33" for="jour1">Debut date :</label>
                        <input class="input3" type="date" name="datemin" value="<?= $datemin ?>" id="jour1" ></br>
                        <label class="i44" for="jour2">Fin date :</label>
                        <input class="input4" type="date" name="datemax" value="<?= $datemax ?>" id="jour2" ></br>
                        <input class="button" type="submit" name="submit" value="Listé les produits entre ces 2 dates">
                    
                    </form>
        
                 <div class="affichage">
                    <table>
                        <thead>
                            <tr>
                            <th>NUMERO</th>
                            <th>DESIGN</th>
                            <th>PRIX UNITAIRE</th>
                            <th>STOCK</th>
                            </tr>
                        </thead>
                        <?php while($row=mysqli_fetch_array($recherche)) { ?>
                        <tr>
                            <td><?php echo $row['numproduit']?></td>
                            <td><?php echo $row['design']?></td>
                            <td><?php echo $row['pu']?></td>
                            <td><?php echo $row['stock']?></td>
                        </tr>
                        <?php } ?>
                    </table>
                 </div>
                
                
            </div>
        </body>
    </html>
    
    