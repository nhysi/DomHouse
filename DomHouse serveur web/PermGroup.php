<?php
 session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Inscription d'un sous utilisateur</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap-contact.js" type="text/javascript"></script>

    </head>
    
	<body>
     <?php include("entete.inc.php"); 
	  if(isset($_SESSION['login'])){
	  if($_SESSION['profil']== 1 || $_SESSION['profil']== 2){
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div class="well well-sm">
		<form role="form" class="form-horizontal" action="PermGroup.php" method="post" id="contactform">
          <fieldset>
            <legend class="text-center">Inscription d'un utilisateur - Permissions de groupe</legend>
			
			<p align="center"><i>Informations de connexion</i></p>
			<p align="center"><span class="label label-info">Tout les champs sont obligatoires</span></p>
			<!-- Login-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="login">Pseudo/Identifiant</label>
              <div class="col-md-6">
                <input id="login" name="login" type="text" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"
				       placeholder="Identifiant de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="mdp">Mot de passe</label>
              <div class="col-md-6">
                <input id="mdp" name="mdp" type="password" value="<?php if (isset($_POST['mdp'])) echo htmlentities(trim($_POST['mdp'])); ?>"
				placeholder="Mot de passe de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Confirmation Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="ConfirmMdp">Confirmation mot de passe</label>
              <div class="col-md-6">
                <input id="ConfirmMdp" name="ConfirmMdp" type="password" value="<?php if (isset($_POST['ConfirmMdp'])) echo htmlentities(trim($_POST['ConfirmMdp'])); ?>"
				placeholder="Confirmation du mot de passe utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Nom-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="nom">Nom</label>
              <div class="col-md-6">
                <input id="nom" name="nom" type="text" value="<?php if (isset($_POST['nom'])) echo htmlentities(trim($_POST['nom'])); ?>"
				       placeholder="Nom de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Prenom-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="prenom">Prenom</label>
              <div class="col-md-6">
                <input id="prenom" name="prenom" type="text" value="<?php if (isset($_POST['prenom'])) echo htmlentities(trim($_POST['prenom'])); ?>" 
				       placeholder="Prenom de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			<p align="center" title="Ajouter l'utilisateur à un groupe ou créer un groupe pour cet utilisateur.Les groupes permettent de donner des permissions à plusieurs utilisateurs à la fois.">
			<i>Choisir un groupe</i><p/>			
			<?php
			include("ConnectBDDRaspberry.php");
			$sqlGrp = 'SELECT COUNT(*) FROM groupe'; //y a t-il des groupes déjà existants?
			$reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			$rowGrp = mysqli_fetch_array($reqGrp,MYSQLI_NUM);
			mysqli_free_result($reqGrp);
			
			if($rowGrp[0]!=0){ //si au moins un groupe existe
			$sqlGrp2 = 'SELECT idgroupe, label, description FROM groupe';
			$reqGrp2 = mysqli_query($linkRaspberry,$sqlGrp2) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			echo '<table id="tabperm" border="1" align="center"><tr><th>Groupe</th><th>Description</th></tr>';
			while($rowGrp2 = mysqli_fetch_array($reqGrp2,MYSQLI_NUM))
			  echo '<td><input type= "radio" name="groupe" value="'.$rowGrp2[0].'">'.$rowGrp2[1].'</td><td>'.$rowGrp2[2].'</td></tr>';
			echo '</table>';  	
			}
			else
			 echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Aucun groupe n\'existe pour le moment</div></div><br/><br/><br/>';
			 echo '<p align="center"><span class="label label-info">Attention, un utilisateur ne peut appartenir qu\'a un seul groupe!</span></p>';
			 echo '<br/><br/>';	
             echo '<p align="center"><a href="creationGroupe.php">Créer un groupe</a></p>';
			?>
			
			<!-- Bouton de validation -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="inscription" value="InscriptionUser" id="bouton-search">Valider</button>
              </div>
            </div>
          </fieldset>
          <?php include("inscriptionSU.php"); ?>
		  </form>
        </div>  <!-- well -->
      </div>
	 </div>  <!-- row -->
	 <?php		
	  }
	   else
	    echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas un utilisateur primaire. </div>
			   </div> <br/> <br/> <br/>';
	  }
	   else
	     echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
			   </div> <br/> <br/> <br/>';
			   
	  include("pied.inc.php"); ?>
    </body>
</html>