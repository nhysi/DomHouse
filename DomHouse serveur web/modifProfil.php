<?php session_start(); 
      include('entete.inc.php');
	  
	  if(isset($_SESSION['login'])){
?>

    <div class="container">

      <div class="row">
	 
	  <div class="col-md-8 col-md-offset-2 "> <div class="well">
		<h2 align="center"> Modification de votre profil </h2>
		
		<h3>Modifier le pseudonyme</h3>
		
		<form class="form-horizontal" action="modifProfil.php" method="post">
		 <!-- Login-->
               <div class="form-group">
                <label class="col-md-3 control-label" for="new_login">Indiquez un nouveau pseudo</label>
              <div class="col-md-6">
                <input name="new_login" value="<?php if (isset($_POST['new_login'])) echo htmlentities(trim($_POST['new_login']));?>" type="text" placeholder="Votre nouveau login" class="form-control">
              </div>
            </div>
			
			 <!-- Bouton -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="modif_login" value="modification_login" class="btn btn-primary btn-lg">Valider</button>
              </div>
            </div>
		</form>
		
		<?php
		
		 if(isset($_POST['modif_login']) && $_POST['modif_login'] == 'modification_login'){
		 if(!empty($_POST['new_login'])){
		 if($_POST['new_login'] != $_SESSION['login']){
		 if(strlen($_POST['new_login']) > 2){			
			include("ConnectBDD.php"); //Connexion à la BDD
			include('ConnectBDDRaspberry.php');	//Connexion à la BDD raspberry
			// on recherche si ce login est déjà utilisé par un autre membre
			$sql = 'SELECT count(*) FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_POST['new_login']).'"';
			$req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
			$data = mysqli_fetch_array($req,MYSQLI_NUM);
			mysqli_free_result($req);
			
			// on recherche l'id du user
			$sql3 = 'SELECT User_ID FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
			$req3 = mysqli_query($link,$sql3) or die('Erreur SQL !<br />'.$sql3.'<br />'.mysql_error());
			$data3 = mysqli_fetch_array($req3,MYSQLI_NUM);
			mysqli_free_result($req3);
			
			if ($data[0] == 0){
			//insertions des données utilisateurs dans la table utilisateur du site web
			$sql2 = 'UPDATE utilisateur SET login="'.mysqli_real_escape_string($link,$_POST['new_login']).'" WHERE User_ID = "'.$data3[0].'"';
			mysqli_query($link,$sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error());
			
			//insertions des données utilisateurs dans la table user du raspberry
			$sql5 = 'UPDATE user SET login="'.mysqli_real_escape_string($linkRaspberry,$_POST['new_login']).'" WHERE idUser = "'.$data3[0].'"';
			mysqli_query($linkRaspberry,$sql5) or die('Erreur SQL !'.$sql5.'<br />'.mysql_error());
			
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-success" role="alert" align="center"> Pseudo changé avec succès! </div></div>';
			
			$grade = $_SESSION['profil'];
			if(!empty($_SESSION['Site']))
			  $site = $_SESSION['Site'];
			
			session_unset();
			session_destroy();
			session_start();
			$_SESSION['login'] = $_POST['new_login'];
			$_SESSION['profil'] = $grade;
			if(!empty($site)) $_SESSION['Site'] = $site;			
			}
		    else
			 echo '<div class="col-md-6 col-md-offset-3"> <div class="alert alert-danger" role="alert" align="center"> Ce pseudo existe déjà! </div></div>';
		 }
		 else
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center"> Le nom  doit contenir au moins 2 caractères </div></div>';
		 }
		 else
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Pseudo identique au votre</div></div>';
		 }
		 else
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Le champ est vide</div></div>';
		 }
		 echo '<br/><br/><br/>';
		?>
		<hr>	
		<h3>Modifier le mot de passe</h3>
	
		<form class="form-horizontal" action="modifProfil.php" method="post">
		
		<!-- Mdp actuel-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="mdp">Mot de passe actuel</label>
              <div class="col-md-6">
                <input name="mdp" type="password" placeholder="Votre mot de passe" class="form-control">
              </div>
            </div>
			<br/>
			<!-- nouveau Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="new_mdp">Nouveau mot de passe</label>
              <div class="col-md-6">
                <input name="new_mdp" type="password" placeholder="Votre nouveau mot de passe" class="form-control">
              </div>
            </div>
			
			<!-- confirmation nouveau Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Confirmation_New_mdp">Confirmation nouveau mot de passe</label>
              <div class="col-md-6">
                <input name="Confirmation_New_mdp" type="password" placeholder="Confirmer votre nouveau mot de passe" class="form-control">
              </div>
            </div>
			
			 <!-- Bouton -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="modif_mdp" value="modification_mdp" class="btn btn-primary btn-lg">Valider</button>
              </div>
            </div>
		</form>
		
		<?php
		
		 if(isset($_POST['modif_mdp']) && $_POST['modif_mdp'] == 'modification_mdp'){
		 if(!empty($_POST['mdp']) && !empty($_POST['new_mdp']) && !empty($_POST['Confirmation_New_mdp'])){
		 if(strlen($_POST['new_mdp']) > 6){ //on vérifie la taille du mdp			
			include("ConnectBDD.php"); //Connexion à la BDD site web
			include('ConnectBDDRaspberry.php');	//Connexion à la BDD raspberry
			
			 //on récupère le sel
			 $sqlSalt = 'SELECT sel FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
			 $reqSalt = mysqli_query($link,$sqlSalt) or die('Erreur SQL !<br />'.mysql_error());
			 $dataSalt = mysqli_fetch_array($reqSalt,MYSQLI_NUM);
			 $salt = $dataSalt[0];
			 mysqli_free_result($reqSalt);
			
			// on vérifie que le mdp introduit est correct
			$sql = 'SELECT count(*) FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_SESSION['login']).'" AND mdp="'.mysqli_real_escape_string($link,sha1($_POST['mdp'].$salt)).'"';
			$req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.mysql_error());
			$data = mysqli_fetch_array($req,MYSQLI_NUM);
			mysqli_free_result($req);
			
			if ($data[0] == 1){ //si le bon mot de passe a été introduit
			
			//sinon on vérifie la concordance new_mdp et new_mdp_confirmation
			$min = 1256488; $max = 895658749958763;
		    $salt = mt_rand(19887859,178957895874569857);
		    $sha1 = sha1($_POST['new_mdp'].$salt);
			
			if($_POST['new_mdp'] == $_POST['Confirmation_New_mdp']){			
			  $sql2 = 'UPDATE utilisateur SET mdp="'.mysqli_real_escape_string($link,$sha1).'", sel="'.$salt.'" WHERE login = "'.$_SESSION['login'].'"';
			  mysqli_query($link,$sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error());
			  
			  $sql4 = 'UPDATE user SET mdp="'.mysqli_real_escape_string($linkRaspberry,$sha1).'", sel="'.$salt.'" WHERE login = "'.$_SESSION['login'].'"';
			  mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !'.$sql4.'<br />'.mysql_error());
			  
			  echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-success" role="alert" align="center"> Mot de passe changé avec succès! </div></div>';					  
			}
			else
			 echo '<div class="col-md-6 col-md-offset-3"> <div class="alert alert-danger" role="alert" align="center"> Le nouveau mot de passe et la confirmation ne correspond pas </div></div>';
			}
		    else
			 echo '<div class="col-md-6 col-md-offset-3"> <div class="alert alert-danger" role="alert" align="center"> Mot de passe incorrect </div></div>';
		 }
		 else
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center"> Le nouveau mot de passe  doit contenir au moins 6 caractères </div></div>';
		 }
		 else
			echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Un ou plusieurs champ(s) sont manquant(s)</div></div>';
		 }
		 echo '<br/><br/><br/>';
		?>
		
		  </div> <!--well--> 
		 </div> <!--col-->
	    </div> <!--row-->
	</div> <!--content-->';
    <?php	
	 }
	 else
		echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div></div><br/><br/><br/>';
	 include('pied.inc.php'); 
	?>