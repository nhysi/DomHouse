<?php
// on se connecte � notre base
$server = "localhost:3307";
$user = "Kevin"; 
$password = "testtest";
$db = "DH";
$connection = mysql_connect("$server","$user","$password") or die("Error");
mysql_select_db($db,$connection);
?>