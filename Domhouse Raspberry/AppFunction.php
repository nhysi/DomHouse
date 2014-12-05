<?php 
	/*
* Fonctions pour l'application mobile
*/
	function dbConnect()
	{
		$host='localhost';
		$user='Kevin';
		$password='testtest';
		$database='DH';
	
		mysql_connect($host,$user,$password) or die ("Erreur de connection au serveur $host");
		mysql_select_db($database) or die ("Erreur de selection de la base de données ");
	}

	function dbDisconnect()
	{
		mysql_close();
	}
	
	function getSalt($login)
	{
		dbConnect();
		$sql = "SELECT sel FROM user WHERE login = '$login'";
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$salt =  mysql_result($req,0);
		mysql_free_result($req);
		dbDisconnect();
		return $salt;
	}
	
	/*
	* Retourne true si la combinaison login/pwd est correcte, false sinon
	*/
	function loginPwdCorrect($login, $pwd)
	{
		$salt = getSalt($login);
		dbConnect();
		$sql = 'SELECT count(*),login FROM user WHERE login="'.mysql_real_escape_string($login).'" AND mdp="'.sha1(mysql_real_escape_string($pwd).$salt).'"'; //j'ai laissé le post. Je sais pas comment utiliser le sha1
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$data = mysql_fetch_array($req);
		dbDisconnect();
		if ($data[0] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	

	/*
	* change le statut de l'équipement. (1 = on  0 = off)
	*/
	function updateStatut($pin,$statutEquip)
	{
		require_once('configuration.php');
		system("gpio mode ".$pins[$pin]." out");
		system("gpio write ".$pins[$pin]." ".$statutEquip);

		system("/var/www/hcc/radioEmission 0 12325621 ".$_['numero']." ".$_['state']);
		/*dbConnect();
		if($statutEquip)
		{
			$sql = "UPDATE equipement SET statut = 1 WHERE Pins = '$pin'";
        }
        else
        {
			$sql = "UPDATE equipement SET statut = 0 WHERE Pins = '$pin'";
        }
        $sql = mysql_query($sql);
		dbDisconnect();*/
	}

	function getPinState($pin){
		require_once('configuration.php');
		$commands = array();
		exec("gpio read ".$pins[$pin],$commands,$return);
		return (trim($commands[0])=="1"?true:false); // =="1"?'on':'off'
}
	
?>