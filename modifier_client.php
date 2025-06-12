<!DOCTYPE html>
<html>
    <head>
        <title> MISE A JOUR </title>
        <link rel="stylesheet" href="modifier_client.css"/>
    </head>
    <body>
        <a class="retour1" href="client.php">Retour</a>
        
            <h1>MODIFIER UN SEUL CLIENT</h1>
            
               <form class="form1" action="modifier_client.php" method="POST">
                
                <label for="num1"> numero actuel</label><br/>
                <input class="input1" type="text" name="id" placeholder="enter code client"/><br/><br/>
                <label for="num1"> nouveau nom</label><br/>
                <input class="input1" type="text" name="nom" placeholder="enter name"/><br/><br/>
                
               <input class="input2" type="submit" name="update" value="MODIFIER"/>

               </form>
        
    </body>
</html>


<?php

$connection = mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'projet2');

if(isset($_POST['update']))
{
  $id=$_POST['id'];
  
  $query="UPDATE client SET nom='$_POST[nom]'  where numclient='$_POST[id]'";
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