<?php
	 // on teste si le visiteur a soumis le formulaire
	 if (isset($_POST['inscription']) && $_POST['inscription'] == 'InscriptionUser') {
	 // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	 if (!empty($_POST['login']) && !empty($_POST['mdp']) && 
	 !empty($_POST['ConfirmMdp']) && !empty($_POST['ConfirmEmail']) &&
	 !empty($_POST['nom']) && !empty($_POST['prenom']) && 
	 !empty($_POST['jour']) && !empty($_POST['mois']) &&!empty($_POST['année']) && !empty($_POST['ville']) && 
	 !empty($_POST['pays']) && !empty($_POST['email']) && !empty($_POST['LienRasp'])
	 && !empty($_POST['code_postal'])) {
	  
      //taille mot de passe minimal	  
	  $taillePWD = 7;
	  
	  //test préliminaires
      if($_POST['mdp'] != $_POST['ConfirmMdp'])
	  echo '<div class="alert alert-danger" role="alert" align="center"> Les 2 mots de passe sont différents </div>';
	  
	  elseif(strlen($_POST['mdp']) < $taillePWD)
	  echo '<div class="alert alert-danger" role="alert" align="center"> Le mot de passe n\'est pas suffisamment long.<br/> La taille doit être minimum de '.$taillePWD.' caractères </div>';
	
	  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
	  echo '<div class="alert alert-danger" role="alert" align="center"> L\'adresse email introduite a un format non adapté </div>';
	
	  elseif($_POST['email'] != $_POST['ConfirmEmail'])
	  echo '<div class="alert alert-danger" role="alert" align="center"> Les 2 adresses emails sont différentes </div>';
	  
	  elseif(strlen($_POST['nom']) < 2)
	  echo '<div class="alert alert-danger" role="alert" align="center"> Le nom  doit contenir au moins 2 caractères </div>';
	  
	  else{
	  include("ConnectBDD.php");
      include("ConnectBDDRaspberry.php");
	  
	  // on recherche si ce login est déjà utilisé par un autre membre
	  $sql = 'SELECT count(*) FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_POST['login']).'"';
	  $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
	  $data = mysqli_fetch_array($req,MYSQLI_NUM);
	  mysqli_free_result($req);

	  // on recherche si cet email est déjà utilisé par un autre membre
	  $sql2 = 'SELECT count(*) FROM utilisateur WHERE email="'.mysqli_real_escape_string($link,$_POST['email']).'"';
	  $req2 = mysqli_query($link,$sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.mysql_error());
	  $data2 = mysqli_fetch_array($req2,MYSQLI_NUM);
	  mysqli_free_result($req2);

	  //calcul de la date et heure
	  $date = date("Y-m-d H:i");
      
	  $jour = $_POST['jour'];
	  $mois = $_POST['mois'];
	  $année = $_POST['année'];
	  
	  if(checkdate($mois,$jour,$année) == TRUE){
	  
	  $date_naissance = date($année."-".$mois."-".$jour);
	  
	  $code_postal = $_POST['code_postal']; //idéal contre les injections SQL sur les valeurs numériques
	  if(is_numeric($code_postal)){
       
	  if ($data[0] == 0 && $data2[0] == 0){
		$salt = mt_rand(19887859,178957895874569857);
		$sha1 = sha1($_POST['mdp'].$salt);
		
	   //insertions des données utilisateurs dans la table user du site web
	   $sql = 'INSERT INTO utilisateur VALUES("'.
       mysqli_insert_id($link).'","'.mysqli_real_escape_string($link,$_POST['login']).'",
	   "'.mysqli_real_escape_string($link,$sha1).'","'.mysqli_real_escape_string($link,$_POST['nom']).'"
	   ,"'.mysqli_real_escape_string($link,$_POST['prenom']).'","'.mysqli_real_escape_string($link,$_POST['email']).'"
	   ,"'.mysqli_real_escape_string($link,$date_naissance).'","'.mysqli_real_escape_string($link,$_POST['pays']).'"
	   ,"'.mysqli_real_escape_string($link,$_POST['ville']).'","'.mysqli_real_escape_string($link,$code_postal).'"
	   ,"'.mysqli_real_escape_string($link,$date).'","'.mysqli_real_escape_string($link,$_POST['LienRasp']).'","'.mysqli_real_escape_string($link,$salt).'")'; //la dernière collonne est pour le sel
	   mysqli_query($link,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());

	   //insertion des données du profil utilisateur dans la table user_profil
	   $sql3 = 'INSERT INTO profil VALUES("'.mysqli_insert_id($link).'","'.mysqli_real_escape_string($link,2).'")';
	   mysqli_query($link,$sql3) or die('Erreur SQL !'.$sql3.'<br />'.mysql_error());
	   
	   //récupération du user_id de la table utilisateur du site web
	   $sqlid = 'SELECT User_ID FROM utilisateur WHERE login = "'.$_POST['login'].'"';
	   $reqId = mysqli_query($link,$sqlid) or die('Erreur SQL !'.$sqlid.'<br />'.mysql_error());
	   $rowId = mysqli_fetch_array($reqId,MYSQLI_NUM);
	   mysqli_free_result($reqId); 
	   
	   //insertion des données utilisateurs dans la table user du raspberry
	   $sqlRasp = 'INSERT INTO user VALUES("'.$rowId[0].'","'.mysqli_real_escape_string($linkRaspberry,$_POST['login']).'",
	   "'.mysqli_real_escape_string($linkRaspberry,$sha1).'","'.mysqli_real_escape_string($linkRaspberry,$_POST['nom']).'"
	   ,"'.mysqli_real_escape_string($linkRaspberry,$_POST['prenom']).'","'.mysqli_real_escape_string($linkRaspberry,$_POST['email']).'"
	   ,"'.mysqli_real_escape_string($linkRaspberry,$date).'","'.mysqli_real_escape_string($linkRaspberry,2).'","'.mysqli_real_escape_string($link,$salt).'")'; //pareil ici pour le sel
	   mysqli_query($linkRaspberry,$sqlRasp) or die('Erreur SQL !'.$sqlRasp.'<br />'.mysql_error());
	   
	   $succes = 'Inscription de l\'utilisateur effectué avec succès!';		
			 echo '<script language="Javascript">
			<!--
			document.location.replace("redirect.php?msg='.$succes.'");
			// -->
			</script>';
	   mysqli_close($linkRaspberry);
	   mysqli_close($link);
	  }
	  else 
	    echo  '<div class="alert alert-danger" role="alert" align="center">Un utilisateur possède déjà cet identifiant ou cette adresse mail.</div>';
	  }
	   else
	    echo  '<div class="alert alert-danger" role="alert" align="center">Le code postal ne doit contenir que des chiffres.</div>'; 
      }
	   else
	    echo  '<div class="alert alert-danger" role="alert" align="center">Le format pour la date de naissance n\'a pas été respecté. Entrez uniquement des chiffres et respectez le format jj/mm/aaaa.</div>'; 
	  }	  
	  }
	   else
	    echo '<div class="alert alert-danger" role="alert" align="center">Un ou plusieurs champs sont vides. Merci de remplir tout les champs.</div>';
	  }
	  ?>

