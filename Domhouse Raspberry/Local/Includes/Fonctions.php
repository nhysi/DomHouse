<?php 

function ConnectBDD($Choix)
 //Si la fonction reçoit 0 alors elle se connecte a la BDD de DomHouse, sinon si elle reçoit 1 alors au Raspberry
{ // Rajouter un comportement par défaut

//if (Ip() == 0){ $server = "localhost" ;} else { $server = "192.168.1.9";} // verifie si en local ou pas
$server = "192.168.1.9";
   if ($Choix == 0) {
	 @$linkD = mysqli_connect("localhost", "Kevin", "testtest", "test","3306");
	 //or die('Impossible de se connecter au serveur MySQL');
		$link = $linkD;
	}
	else if($Choix==1) {
		echo '<!--'; $linkR = mysqli_connect($server, "Kevin", "testtest", "DH","3307") ; echo '-->';
		$link = $linkR;
		
	}
	if (mysqli_connect_errno()) {
		printf("Échec de la connexion : %s\n", mysqli_connect_error());
		exit();
    }
	return $link;
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

?>