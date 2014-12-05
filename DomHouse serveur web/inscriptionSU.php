<?php
	 // on teste si le visiteur a soumis le formulaire
	 if (isset($_POST['inscription']) && $_POST['inscription'] == 'InscriptionUser') {
	 // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	 if (!empty($_POST['login']) && !empty($_POST['mdp']) && !empty($_POST['nom']) && !empty($_POST['prenom'])){
	  
      //taille mot de passe minimal	  
	  $taillePWD = 7;
	  
	  //test préliminaires
      if($_POST['mdp'] != $_POST['ConfirmMdp'])
	  echo '<div class="alert alert-danger" role="alert" align="center"> Les 2 mots de passe sont différents </div>';
	  
	  elseif(strlen($_POST['mdp']) < $taillePWD)
	  echo '<div class="alert alert-danger" role="alert" align="center"> Le mot de passe n\'est pas suffisamment long.<br/> La taille doit être minimum de '.$taillePWD.' caractères </div>';
	  
	  else{
	  include("ConnectBDD.php");
	  include("ConnectBDDRaspberry.php");
	  
	  //on recup l'email de l'utilisateur primaire
	  $sqlmail = 'SELECT email FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
	  $reqmail = mysqli_query($link,$sqlmail) or die('Erreur SQL !<br />'.$sqlmail.'<br />'.mysql_error());
	  $datamail = mysqli_fetch_array($reqmail,MYSQLI_NUM);
	  mysqli_free_result($reqmail);
	  
	  // on recherche si ce login est déjà utilisé par un autre membre
	  $sql = 'SELECT count(*) FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_POST['login']).'"';
	  $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
	  $data = mysqli_fetch_array($req,MYSQLI_NUM);
	  mysqli_free_result($req);

	  //calcul de la date et heure
	  $date = date("Y-m-d H:i");
	  
	  if ($data[0] == 0){
	  $min = 1256488; $max = 895658749958763;
	  $salt = mt_rand(19887859,178957895874569857);
	  $sha1 = sha1($_POST['mdp'].$salt);
	  
	   //insertions des données utilisateurs dans la table users du site web
	   $sql2 = 'INSERT INTO utilisateur(User_ID,login,mdp,nom,prenom,email,date_inscription,site_internet,sel) VALUES("'.
       mysqli_insert_id($link).'","'.mysqli_real_escape_string($link,$_POST['login']).'",
	   "'.mysqli_real_escape_string($link,$sha1).'","'.mysqli_real_escape_string($link,$_POST['nom']).'"
	   ,"'.mysqli_real_escape_string($link,$_POST['prenom']).'","'.mysqli_real_escape_string($link,$datamail[0]).'","'.$date.'","'.$_SESSION['Site'].'","'.$salt.'")';
	   mysqli_query($link,$sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error());

	   //insertion des données du profil utilisateur dans la table user_profil
	   $sql3 = 'INSERT INTO profil VALUES("'.mysqli_insert_id($link).'","'.mysqli_real_escape_string($link,3).'")';
	   mysqli_query($link,$sql3) or die('Erreur SQL !'.$sql3.'<br />'.mysql_error());
	   
       //récupération du user_id de la table utilisateur du site web
	   $sqlid = 'SELECT User_ID FROM utilisateur WHERE login = "'.$_POST['login'].'"';
	   $reqId = mysqli_query($link,$sqlid) or die('Erreur SQL !'.$sqlid.'<br />'.mysql_error());
	   $rowId = mysqli_fetch_array($reqId,MYSQLI_NUM);
	   mysqli_free_result($reqId); 	  

	  //insertions des données utilisateurs dans la table users du raspberry
	   $sql4 = 'INSERT INTO user(idUser,login,mdp,nom,prenom,email,dateInscris,sel) VALUES("'.
       $rowId[0].'","'.mysqli_real_escape_string($linkRaspberry,$_POST['login']).'",
	   "'.mysqli_real_escape_string($linkRaspberry,$sha1).'","'.mysqli_real_escape_string($linkRaspberry,$_POST['nom']).'"
	   ,"'.mysqli_real_escape_string($linkRaspberry,$_POST['prenom']).'","'.$datamail[0].'","'.$date.'","'.$salt.'")';
	   mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !'.$sql4.'<br />'.mysql_error());
	   
	   //recupération de l'id user du nouvel inscris
	   $sql6 = 'SELECT idUser FROM user WHERE login="'.mysqli_real_escape_string($linkRaspberry,$_POST['login']).'"';
	   $req6 = mysqli_query($linkRaspberry,$sql6) or die('Erreur SQL !<br />'.$sql6.'<br />'.mysql_error());
	   $data6 = mysqli_fetch_array($req6,MYSQLI_NUM);
	   mysqli_free_result($req6);
	   
	   
	   //recup checkbox et insertion des permission individuelles dans la table user_eq du raspberry
	   $sql7 = 'SELECT idEquip FROM equipement';
	   $req7 = mysqli_query($linkRaspberry,$sql7) or die('Erreur SQL !<br />'.$sql7.'<br />'.mysql_error());
	   while($check = mysqli_fetch_array($req7,MYSQLI_NUM)){
	   if(!empty($_POST[$check[0]])){ 
	    $sql5 = 'INSERT INTO user_eq VALUES("'.$data6[0].'","'.$_POST[$check[0]].'","'.$_POST['Perm'.$check[0].''].'")';
	    mysqli_query($linkRaspberry,$sql5) or die('Erreur SQL !'.$sql5.'<br />'.mysql_error());
		}
	   }
		mysqli_free_result($req7);
		
		if(!empty($_POST['groupe'])){ //si il s'agit d'une permissions de groupe
		
	   //si on met un utilisateur dans un groupe, insertion des données dans la table userGrp
	   $sqlAppartenanceGroupe = 'INSERT INTO userGrp VALUES("'.$data6[0].'","'.$_POST['groupe'].'")';
	   mysqli_query($linkRaspberry,$sqlAppartenanceGroupe) or die('Erreur SQL !'.$sqlAppartenanceGroupe.'<br />'.mysql_error());
	   }
	   mysqli_close($link);
	   mysqli_close($linkRaspberry);
	   
	   $succes = 'Inscription de l\'utilisateur effectué avec succès!';		
			 echo '<script language="Javascript">
			<!--
			document.location.replace("redirect.php?msg='.$succes.'");
			// -->
			</script>';
	  }
	  else 
	    echo  '<div class="alert alert-danger" role="alert" align="center">Un utilisateur possède déjà cet identifiant.</div>';
	  }	  
	  }
	   else
	    echo '<div class="alert alert-danger" role="alert" align="center">Un ou plusieurs champs sont vides. Merci de remplir tout les champs.</div>';
	  }
	  ?>