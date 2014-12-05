<?php
require_once('common.php');

$result['state']  = 0; //initialisation des variables du tableau $result
$result['error']  = ''; 


switch($_['action']){
	case 'changeState':
		//Definis le PIN en tant que sortie
		system("gpio mode ".$pins[$_['pin']]." out");
		//Active/désactive le pin
		system("gpio write ".$pins[$_['pin']]." ".$_['state']);
		$result['state'] = 1;
		
	break;
	case 'changeState2':
		system("/var/www/hcc/radioEmission 0 12325621 ".$_['numero']." ".$_['state']);
	break;
	default:
		$result['error']  = 'Aucune action définie';
	break;
}

echo '('.json_encode($result).')';


?>