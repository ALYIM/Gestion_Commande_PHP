<?php

include'connexion.php';

if(isset($_POST['submit'])){
    $numclient=$_POST['numclient'];
    $numproduit=$_POST['numproduit'];
    $qte=$_POST['qte'];
    $date=$_POST['date'];
    
    $sql="insert into commande(numclient,numproduit,qte,date) values('$numclient','$numproduit','$qte','$date')";
    $result=mysqli_query($con,$sql);
    
    if($result){
        $csql="update produit,commande set produit.stock=produit.stock-$qte where produit.numproduit='$numproduit'";
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
            <title> C O M M A N D E </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="commande.css"/>
        </head>
        <body>
            <div id="divbody">
              <a href="chiffre_affaire.php" style="color:white;margin-left:1040px;position:absolute;">chiffre d'affaire par chaque client</a>
                 <div class="div1">
                          <img class="img1" src="image/commander.png" alt="iconcom" style="width:100pt;height:100pt;">
                          <a href="modifier_commande.php">
                              <img class="modifier1" src="image/modifier.png" alt="iconmodif" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p1">modification des commandes</p>
                
                          <a href="supprimer_commande.php">
                              <img class="supprimer1" src="image/supprimer.png" alt="iconsuppr" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p2">suppression des commandes</p>
                             
                          <a href="cherche_commande.php">
                              <img class="cherche1" src="image/rechercher2.png" alt="iconcherch" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p3">chercher des commandes</p>   
                
                             <p class="retour1"> <a class="lien1" href="acceuil.php">retour<br/>à l'acceuil</a> </p>
                 </div>
                         
                 <div class="div2">
                         <form class="form1" method="post" action="commande.php">
                            <img class="ajouter1" src="image/ajouter.png" alt="iconajout" style="width:50pt;height:50pt;"><br/>
                            <label for="num"> Numero de client </label><br/>
                            <input class="input1" type="text" name="numclient" id="num" placeholder="c1"><br/><br/>
                            <label for="numm"> Numero de produit </label><br/>
                            <input class="input1" type="text" name="numproduit" id="nomm" placeholder="p1"><br/><br/>
                            <label for="qte"> Quantité commandé </label><br/>
                            <input class="input1" type="number" name="qte" id="qte" placeholder="100"><br/><br/>
                            <label for="date"> date de commande </label><br/>
                            <input class="input1" type="date"  name="date" id="date" placeholder="2022-12-15"><br/><br/>
                
                            <input class="input2" type="submit" name='submit' value="a j o u t e r">
                         </form>      
                 </div>            
                         
                 <div class="div3">
                      <table clas="table1">
                        <thead>
                            <tr>
                                <th class="th1">Numero client </th>
                                <th            >Numero produit </th>
                                <th            >Quantité commandé </th>
                                <th class="th2">date de commande </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql="select * from commande";
                            $result=mysqli_query($con,$sql);
                            if($result){
                                while($row=mysqli_fetch_assoc($result)){
                                    $numclient=$row['numclient'];
                                    $numproduit=$row['numproduit'];
                                    $qte=$row['qte'];
                                    $date=$row['date'];
                                    echo'<tr>
                                    <td>'.$numclient.'</td>
                                    <td>'.$numproduit.'</td>
                                    <td>'.$qte.'</td>
                                    <td>'.$date.'</td>
                                    </tr>';
                                    
                                }
                            }
                          ?>
                               <tr>
                                <td class="td1">......</td>
                                <td style="color:black; ">......</td>
                                <td style="color:black; ">......</td>
                                <td class="td2">......</td>
        
                               </tr>
                        </tbody>
                    </table>  
                 </div>
                 
            </div>

        </body>
    </html>