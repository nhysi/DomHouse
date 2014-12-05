<?php

function getPinState($pin,$pins){
	$commands = array();
	exec("gpio read ".$pins[$pin],$commands,$return);
	return (trim($commands[0])=="1"?'on':'off');
}

function secure($string){
	return htmlentities(stripslashes($string),NULL,'UTF-8');
}

?>