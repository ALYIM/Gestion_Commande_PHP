<!DOCTYPE html>
<html>
    <head>
        <title> MISE A JOUR </title>
        <link rel="stylesheet" href="modifier_commande.css"/>
    </head>
    <body>
        <a class="retour1" href="commande.php">Retour</a>
        
            <h1>MODIFIER UN SEUL COMMANDE</h1>
            
               <form class="form1" action="modifier_commande.php" method="POST">
                
                <label for="num1"> numero du client</label><br/>
                <input class="input1" type="text" name="numclient" placeholder="enter code client"/><br/><br/>
                <label for="num1"> numero du produit</label><br/>
                <input class="input1" type="text" name="numproduit" placeholder="enter code produit"/><br/><br/>
                <label for="num1"> nouveau Quantité de produit commandé</label><br/>
                <input class="input1" type="number" name="qte" placeholder="enter nouveau quantité"/><br/><br/>
                <label for="num1"> nouveau date (date de modification)</label><br/>
                <input class="input1" type="date" name="date" placeholder="enter date actuel"/><br/><br/>
                
               <input class="input2" type="submit" name="update" value="MODIFIER"/>

               </form>
        
    </body>
</html>


<?php

$connection = mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'projet2');

if(isset($_POST['update']))
{
  $numclient=$_POST['numclient'];
  $numproduit=$_POST['numproduit'];
  $qte=$_POST['qte'];
  $date=$_POST['date'];
  
  $query="UPDATE commande SET qte='$_POST[qte]',date='$_POST[date]'  where numclient='$_POST[numclient]' and numproduit='$_POST[numproduit]'";
  $query_run = mysqli_query($connection,$query);
  
  if($query_run)
  {
    echo'<script type="text/javascript">alert("Data update")</script>';
  }
  else
  {
    echo'<script type="text/javascript">alert("Data Not update")</script>';
  }
}

?>