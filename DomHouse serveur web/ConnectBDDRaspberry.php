<?php
// on se connecte à notre base
$server = "192.168.1.9";
$port = "3307";
$user = "Kevin"; 
$password = "testtest";
$db = "DH";
$linkRaspberry = mysqli_connect($server,$user,$password,$db,$port) ;
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}
?>
