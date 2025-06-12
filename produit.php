<?php

include'connexion.php';

if(isset($_POST['submit'])){
    $numproduit=$_POST['numproduit'];
    $design=$_POST['design'];
    $pu=$_POST['pu'];
    $stock=$_POST['stock'];
    
    $sql="insert into produit(numproduit,design,pu,stock) values('$numproduit','$design','$pu','$stock')";
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
            <title>P R O D U I T </title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="produit.css"/>
        </head>
        <body>
            <div id="divbody">
              
                 <div class="div1">
                          <img class="img1" src="image/produit.png" alt="iconpro" style="width:100pt;height:100pt;">
                          <a href="modifier_produit.php">
                              <img class="modifier1" src="image/modifier.png" alt="iconmodif" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p1">modification de produit</p>
                
                          <a href="supprimer_produit.php">
                              <img class="supprimer1" src="image/supprimer.png" alt="iconsuppr" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p2">suppression de produit</p>
                             
                          <a href="cherche_produit.php">
                              <img class="cherche1" src="image/rechercher2.png" alt="iconcherch" style="width:40pt;height:40pt;">
                          </a>
                             <p class="p3">chercher de produit</p>   
                
                             <p class="retour1"> <a class="lien1" href="acceuil.php">retour<br/>à l'acceuil</a> </p>
                 </div>
                         
                 <div class="div2">
                         <form class="form1" method="post" action="produit.php">
                            <img class="ajouter1" src="image/ajouter.png" alt="iconajout" style="width:50pt;height:50pt;"><br/>
                            <label for="num"> Numero du produit </label><br/>
                            <input class="input1" type="text" name="numproduit" id="num" placeholder="p1"><br/><br/>
                            <label for="nom"> Inserer un design </label><br/>
                            <input class="input1" type="text" name="design" id="nom" placeholder="banane"><br/><br/>
                            <label for="pu"> prix unitaire </label><br/>
                            <input class="input1" type="number" name="pu" id="pu" placeholder="100055"><br/><br/>
                            <label for="stock"> stock </label><br/>
                            <input class="input1" type="number" name="stock" id="stock" placeholder="102"><br/><br/>
                
                            <input class="input2" type="submit" name='submit' value="a j o u t e r">
                         </form>      
                 </div>            
                         
                 <div class="div3">
                       <table clas="table1">
                        <thead>
                            <tr>
                                <th class="th1">Numero </th>
                                <th            >design </th>
                                <th            >prix unitaire </th>
                                <th class="th2">stock </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql="select * from produit order by numproduit asc";
                            $result=mysqli_query($con,$sql);
                            if($result){
                                while($row=mysqli_fetch_assoc($result)){
                                    $numproduit=$row['numproduit'];
                                    $design=$row['design'];
                                    $pu=$row['pu'];
                                    $stock=$row['stock'];
                                    echo'<tr>
                                    <td>'.$numproduit.'</td>
                                    <td>'.$design.'</td>
                                    <td>'.$pu.'</td>
                                    <td>'.$stock.'</td>
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