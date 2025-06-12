<?php

include'connexion.php';

if(isset($_POST['submit'])){
    $numero=$_POST['numero'];
    $pseudo=$_POST['pseudo'];
    
    $sql="insert into client(numclient,nom) values('$numero','$pseudo')";
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
            <title>C L I E N T</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="client.css"/>
        </head>
        <body>
            <div id="divbody">
              
                 <div class="div1">
                          <img class="img1" src="image/client1.png" alt="iconcli" style="width:100pt;height:100pt;">
                          <a href="modifier_client.php">
                              <img class="modifier1" src="image/modifier.png" alt="iconmodif" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p1">modifier un(e) client(e)</p>
                
                          <a href="supprimer_client.php">
                              <img class="supprimer1" src="image/supprimer.png" alt="iconsuppr" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p2">supprimer un(e) client(e)</p>
                             
                          <a href="cherche_client.php">
                              <img class="cherche1" src="image/rechercher2.png" alt="iconcherch" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p3">chercher un(e) client(e)</p>   
                
                             <p class="retour1"> <a class="lien1" href="acceuil.php">retour<br/>à l'acceuil</a> </p>
                 </div>
                         
                 <div class="div2">
                         <form class="form1" method="post" action="client.php">
                            <img class="ajouter1" src="image/ajouter.png" alt="iconajout" style="width:50pt;height:50pt;"><br/>
                            <label for="num"> Numero du client </label><br/>
                            <input class="input1" type="text" name="numero" id="num" placeholder="c1"><br/><br/>
                            <label for="nom"> Inserer un nom </label><br/>
                            <input class="input1" type="text" name="pseudo" id="nom" placeholder="Rakotokoto"><br/><br/>
                
                            <input class="input2" type="submit" name='submit' value="a j o u t e r">
                         </form>      
                 </div>            
                         
                 <div class="div3">
                    <table clas="table1">
                        <thead>
                            <tr>
                                <th class="th1"> NUMERO </th>
                                <th            > NOM </th>
                                <th            > LISTE DES PRODUITS COMMANDE </th>
                                <th class="th2"> FACTURE </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql="select * from client order by numclient asc";
                            $result=mysqli_query($con,$sql);
                            if($result){
                                while($row=mysqli_fetch_assoc($result)){
                                    $numero=$row['numclient'];
                                    $nom=$row['nom'];
                                    echo'<tr>
                                    <td>'.$numero.'</td>
                                    <td>'.$nom.'</td>
                                    <td>
                                      <a href="liste_pro_com_cli.php?numclient='.$row['numclient'].'"> Produit commandé </a>
                                    </td>
                                    <td>
                                      <a href="facture_client.php?numclient='.$row['numclient'].'"> Facture </a>
                                    </td>
                                    </tr>';
                                    
                                }
                            }
                          ?>
                               <tr>
                                <td class="td1">......</td>
                                <td style="color:black;">......</td>
                                <td style="color:black;">......</td>
                                <td class="td2">......</td>
        
                               </tr>
                        </tbody>
                    </table>
                 
                 </div>
                 
            </div>
        </body>
    </html>
    
    