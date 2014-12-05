<!DOCTYPE html>
<html>

<head>
	<title>DomHouse-Local </title>
	<meta name="description" content="Raspberry-Local">
	<link rel="stylesheet" href="Css/css.css">
	<meta charset="utf-8"/>
</head>

<body>
<?php
	require_once('Fonctions.php');
?>

<div class="Body">
<!------------------------------------- PARTIE INTERFACE ------------------------------------------------>
	
    <br/>
	<form class="Formulaire2" action="index.php" method="post">
        <legend class="Titre_Formulaire">Connectez-vous à votre panel en local</legend>
			<div class="Separation"> </div>
			<!-- Login-->
            <div class="Ligne">
				<label class="Titre_Ligne_Formulaire" for="login">Login</label>
				<input name="login" type="text" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login']));?>" type="text" placeholder="Votre identifiant" class="Champ_Ligne_Formulaire">
			</div>
			<!-- Mdp-->
            <div class="Ligne">
				<label class="Titre_Ligne_Formulaire" for="mdp">Mot de passe</label>
                <input name="mdp" type="password" placeholder="Votre mot de passe" class="Champ_Ligne_Formulaire">
            </div> 
            <!-- Bouton -->
            <div class="Bouton2">
				<button type="submit" name="connexion" value="Connexion" class="BoutonDesign2">Connexion</button>
			</div>
			<div class="Espace2"></div>
	</form>
		  
<!------------------------------------------ PARTIE COMMANDES ------------------------------------------>
	<?php
    // on teste si le visiteur a soumis le formulaire de connexion
    if(isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion'){
    if((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['mdp']) && !empty($_POST['mdp']))){
    
		$link = ConnectBDD(1); //Connection à la BDD du raspberry
		//on récupère le sel
		$sqlSalt = 'SELECT sel FROM user WHERE login="'.mysqli_real_escape_string($link,$_POST['login']).'"';
		$reqSalt = mysqli_query($link,$sqlSalt) or die('Erreur SQL !<br />'.mysql_error());
		$dataSalt = mysqli_fetch_array($reqSalt,MYSQLI_NUM);
		$salt = Secure($link, $dataSalt[0]);
		mysqli_free_result($reqSalt);
	  

     // on teste si une entrée de la base contient ce couple login / pass
     $sql = 'SELECT count(*),idUser FROM user WHERE login="'.Secure($link,$_POST['login']).'" AND mdp="'.Secure($link,sha1($_POST['mdp'].$salt)).'"';
     $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.mysql_error());
     $data = mysqli_fetch_array($req,MYSQLI_BOTH);

	 // Récupération des variables necessaires à la vérification du champ 'grade_id' de la BDD
	 $id = $data['idUser'];

	 // Récupération de la valeur du champ actif pour le login $login	
	 $stmt = mysqli_query($link,"SELECT idProfil FROM user WHERE idUser = '$id' ")
	 or die("Erreur SQL!".mysql_error());
	
	 while($row = mysqli_fetch_array($stmt,MYSQLI_NUM))
     $grade = $row[0]; 
		
     mysqli_free_result($req);
	 mysqli_free_result($stmt);

     // si on obtient une réponse, alors l'utilisateur est un membre
     if ($data[0] == 1) {
       session_start();
	   $_SESSION['login'] = $_POST['login'];
       $_SESSION['profil'] = $grade; 
	   if(!empty($site)) $_SESSION['Site'] = $site['site_internet'];
	   mysqli_close($link);	 	
	   header("Location:mainboard.php");
     }
	 // si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
     elseif ($data[0] == 0) $erreur = '<div class="alert alert-danger" role="alert" align="center">Combinaison login/mot de passe incorrecte. Veuillez réessayer.</div>';
     // sinon, alors la, il y a un gros problème :)
     else $erreur = '<div class="alert alert-danger" role="alert" align="center"> Erreur interne. Merci de réessayer plus tard. </div>';
     }
     else $erreur = '<div class="alert alert-danger" role="alert" align="center"> Au moins un des champs est vide. Merci de remplir tout les champs requis. </div>';
    }
    ?>
		  
</div>
<?php include("Includes/Footer.php"); ?>
</body>

</html>