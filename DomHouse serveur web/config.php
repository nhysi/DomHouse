<?php
//Tableau de correspondant PIN physiques/PIN Logiques (de la librairie wiringPI)
$pins = array();
$pins[7] = 7;
$pins[11] = 0;
$pins[12] = 1;
$pins[13] = 2;
$pins[15] = 3;
$pins[16] = 4;
$pins[18] = 5;
$pins[22] = 6;
$pins[29] = 21;
$pins[31] = 22;
$pins[32] = 26;
$pins[33] = 23;
$pins[35] = 24;
$pins[36] = 27;
$pins[37] = 25;
$pins[38] = 28;
$pins[40] = 29;

function getPinState($pin,$pins){
	$commands = array();
	exec("gpio read ".$pins[$pin],$commands,$return);
	return (trim($commands[0])=="1"?'on':'off');
}

function panelRaspeberry($profil, $site, $login){

			if(!empty($site)) //On verifie que l'utilisateur a bien un site internet(serveur sur le Raspberry) avant d'afficher le panel.
			{
			include('ConnectBDD.php');
			$sql = 'SELECT User_ID, mdp FROM utilisateur WHERE login = "'.mysqli_real_escape_string($link,$login).'"';
			        $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$row = mysqli_fetch_array($req,MYSQLI_ASSOC);
					mysqli_free_result($req);
			echo '   <br/>
					 <div class="control_window">
						<IFRAME src="'.$site.'/main.php?u_id='.urlencode($row['User_ID']).'&login='.urlencode($login).'&mdp='.urlencode($row['mdp']).'" class="radius" width=100% height=700 scrolling=auto frameborder=0> </IFRAME>
					 </div>
					<br/><br/></div>';
					mysqli_close($link);
			}
			else
				 echo '<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger" role="alert" align="center"> Vous n\'avez pas de Raspberry connecté pour le moment. </div>
					</div> <br/> <br/> <br/> <br/>';
		}
  

?>