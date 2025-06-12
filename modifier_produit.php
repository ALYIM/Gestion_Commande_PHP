<!DOCTYPE html>
<html>
    <head>
        <title> MISE A JOUR </title>
        <link rel="stylesheet" href="modifier_produit.css"/>
    </head>
    <body>
        <a class="retour1" href="produit.php">Retour</a>
        
            <h1>MODIFIER UN SEUL PRODUIT</h1>
            
               <form class="form1" action="modifier_produit.php" method="POST">
                
                <label for="num1"> numero actuel</label><br/>
                <input class="input1" type="text" name="numproduit" placeholder="enter code produit"/><br/><br/>
                <label for="num1"> nouveau design</label><br/>
                <input class="input1" type="text" name="design" placeholder="enter design"/><br/><br/>
                <label for="num1"> nouveau prix unitaire</label><br/>
                <input class="input1" type="number" name="pu" placeholder="enter prix unitaire"/><br/><br/>
                <label for="num1"> nouveau stock</label><br/>
                <input class="input1" type="number" name="stock" placeholder="enter stock"/><br/><br/>
                
               <input class="input2" type="submit" name="update" value="MODIFIER"/>

               </form>
        
    </body>
</html>


<?php

$connection = mysqli_connect("localhost","root","root");
$db=mysqli_select_db($connection,'projet2');

if(isset($_POST['update']))
{
  $numproduit=$_POST['numproduit'];
  $design=$_POST['design'];
  $pu=$_POST['pu'];
  $stock=$_POST['stock'];
  
  $query="UPDATE produit SET design='$_POST[design]',pu='$_POST[pu]',stock='$_POST[stock]'  where numproduit='$_POST[numproduit]'";
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