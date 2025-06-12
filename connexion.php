<?php

$con=new mysqli('localhost','root','','database');

if($con){
    echo"Connexion successfull";
}else{
    die(mysqli_error($con));
}

?>