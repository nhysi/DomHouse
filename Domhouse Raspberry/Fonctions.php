<?php 

function ConnectBDD($Choix)
 //Si la fonction reçoit 0 alors elle se connecte a la BDD de DomHouse, sinon si elle reçoit 1 alors au Raspberry
{ // Rajouter un comportement par défaut
   switch($Choix) {
	case 0:
		$link = mysqli_connect("localhost", "Arnaud", "testtest", "test","3306");
		return $link;
		break;
	case 1:
		$link = mysqli_connect("192.168.1.9", "Kevin", "testtest", "DH","3307");
		return $link;
		break;
	case 2: //Connection a partir du raspberry a sa propre base de donnée
		$server = "192.168.1.9:3307";
		$user = "Kevin"; 
		$password = "testtest";
		$db = "DH";
		$link = mysql_connect("$server","$user","$password") or die("Error");
		mysql_select_db($db,$connection);
		return $link;
		break;
	}
}


function Ip() //PErmet de voir si l'utilisateur est en local ou non
{
	$ip = explode(".", $_SERVER["REMOTE_ADDR"]);
	if($ip[0] == 192 or $ip[0] == 10)
	{
		if($ip[1] == 168 or $ip[1] == 0)
		{
			if($ip[2] == 1 or $ip[2] == 0)
			{
				$ok = 0; //L'adresse est local
			}
			else $ok = 1;
		}
		else $ok = 1;
	}
	else $ok = 1;
	return $ok;
}

function Deco($Link)
 //Déconnecte l'utilisateur de sa session
{
    mysqli_close($Link);
	exit();
}


function DecoSession()
 //Déconnecte l'utilisateur de sa session
{
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

function Secure($BDD,$VarPasSecure)
 //Sécurise les variables avant de les utiliser ou de les stocker dans la BDD
{
   $VarSecure = mysqli_real_escape_string($BDD,$VarPasSecure);
   return $VarSecure;
}

function Salt() //Renvoie Simplement un nombre au hasard utilisé pour le hashage du MDP
{
	$min = 1256488;
	$max = 895658749958763;
	$Salt = mt_rand(19887859,178957895874569857);
	return $Salt;
}
function Crypte($Mdp,$Salt) 
//La fonction prend un MDP en paramètre, crée un Salt et mélange les deux pour renvoyer le MDP crypté.
{
	$sha1 = sha1($Mdp.$Salt);
	return $sha1;
}

function Compare($Val,$Val2) //Permet de comparer les MDP Hashé par exemple
{
	if($Val == $Val2) return 1;
	else return 0;
}

function Etat($Val) 
{
	if($Val) return "Allumé";
	else return "Eteint";
}

?>