<!DOCTYPE html>
    <html>
        <head>
            <title> R E C H E R C H E  par le Numero du client  </title>
            <meta http-equiv="content-type" content="text/html;charset=utf-8" />          
            <style>
                a{
                    color:red;
                }
                
                table{
                    border:2px white solid;
                    border-collapse:collapse;      
                }
                
                .table2{
                    margin-left:70px;
                    margin-top:20px;
                }
                
                th,td{
                    border:2px white solid;
                    padding:10px;
                    padding-left:20px;
                    padding-right:20px;
                }
                
                th{
                    color:black;
                }
                
                legend{
                    color:white;
                    font-size:25px;
                    
                }
                
                body{
                    background-color:black;
                    color:white;
                }
                
                .div2{
                    text-align: center;
                    background-color:rgb(0,100,120);
                    border :2px white solid;
                    border-top-left-radius: 15px;
                    border-bottom-left-radius: 15px;
                    border-top-right-radius: 15px;
                    border-bottom-right-radius: 15px;
                    margin-top:30px;
                    margin-left:150pt;
                    color : white;
                    height : 430pt;
                    width : 650pt;
                }
                
                .input1{
                    margin-top:15px;
                   border:1px maroon solid;
                   border-radius:15px;
                    height : 30px;;
                   width : 170pt;    
                  }

               .input2{
                    background-color:rgb(120,120,0);
                    border:1px black solid;
                    color:black;
                    border-radius:15px;
                    height : 30px;
                    width : 100pt;
                    font-size:20px;
                 }

              .input2:hover{
                   background-color:maroon;
                   border:2px rgb(120,120,0) solid;
                   color:rgb(120,120,0);
                   font-weight:bold;
      
                }
            </style>
        </head>    
        <body>
            <a class="retour1" href="commande.php">Retour</a>

<!--RECHERCHE DES COMMANDE PAR le NUMERO du client-->
<?php

$bdd2=new PDO('mysql:host=localhost;dbname=database;charset=utf8','root','');

$liste2 =$bdd2->query('select * from commande order by numclient asc');

if(isset($_GET['k']) AND !empty($_GET['k'])){
$k = htmlspecialchars($_GET['k']);    
$liste2 =$bdd2->query("select * from commande where numclient='$k'");
}
?>

<div class="div2">
<form method="GET">
    <legend> RECHERCHER DES COMMANDES PAR LE NUMERO DU CLIENT </legend>
    <input class="input1" type="search" name="k" placeholder=".......Rechercher......."/><br/><br/>
    <input class="input2" type="submit" value="Valider"/>
</form>

<table class="table2">
<tr>
    <th> NUMERO CLIENT </th>
    <th> NUMERO PRODUIT </th>
    <th> QUANTITE </th>
    <th> DATE DE COMMANDE </th>
</tr>

<?php if($liste2->rowCount() > 0) { ?>
    <?php while($b = $liste2->fetch()){ ?>
    <tr>
      <td><?=$b['numclient']  ?></td>
      <td><?=$b['numproduit'] ?></td>
      <td><?=$b['qte'] ?></td>
      <td><?=$b['date'] ?></td>
    </tr>
    <?php } ?>
</table>

<?php } else { ?>
Aucun résultat pour <?php echo $k?>
<?php } ?>
</div>
         </body>
    </html>