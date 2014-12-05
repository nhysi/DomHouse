<?php
// on se connecte à notre base
$server = "192.168.1.9:3307";
$user = "Kevin"; 
$password = "testtest";
$db = "DH";
$connection = mysql_connect("$server","$user","$password") or die("Error");
mysql_select_db($db,$connection);
?>