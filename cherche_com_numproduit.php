<!DOCTYPE html>
    <html>
        <head>
            <title> R E C H E R C H E  par le numero du produit </title>
            <meta http-equiv="content-type" content="text/html;charset=utf-8" />          
            <style>
                a{
                    color:red;
                }
                
                table{
                    border:2px white solid;
                    border-collapse:collapse;      
                }
                
                .table1{
                    margin-left:50px;
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
                
                .div1{
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
<!--RECHERCHE DES COMMANDE PAS LE numero de produit-->

<?php
$bdd=new PDO('mysql:host=localhost;dbname=database;charset=utf8','root','');

$liste =$bdd->query('select * from commande order by numproduit asc');

if(isset($_GET['q']) AND !empty($_GET['q'])){
$q = htmlspecialchars($_GET['q']);    
$liste =$bdd->query("select * from commande where numproduit='$q'");
}
?>
<div class="div1">
<form method="GET">
    <legend> RECHERCHER DES COMMANDES PAR LE NUMERO DU PRODUIT </legend>
    <input class="input1" type="search" name="q" placeholder=".......Rechercher......."/><br/><br/>
    <input class="input2" type="submit" value="Valider"/>
</form>

<table class="table1">
<tr>
    <th> NUMERO DU CLIENT </th>
    <th> NUMERO DU PRODUIT </th>
    <th> QUANTITE </th>
    <th> DATE DE COMMANDE </th>
</tr>

<?php if($liste->rowCount() > 0) { ?>
    <?php while($a = $liste->fetch()){ ?>
    <tr>
      <td><?=$a['numclient']  ?></td>
      <td><?=$a['numproduit'] ?></td>
      <td><?=$a['qte'] ?></td>
      <td><?=$a['date'] ?></td>
      
    </tr>
    <?php } ?>
    
</table>

<?php } else { ?>
Aucun résultat pour <?php echo $q?>
<?php } ?>
</div>


         </body>
    </html>