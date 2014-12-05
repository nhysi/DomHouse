<?php
 session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Inscription d'un utilisateur</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap-contact.js" type="text/javascript"></script>

    </head>
    
	<body>
     <?php include("entete.inc.php"); 
	  if(isset($_SESSION['login'])){
	  if($_SESSION['profil']== 1){   
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div class="well well-sm">
         <form role="form" class="form-horizontal" action="inscriptionUser.php" method="post" id="contactform">
          <fieldset>
            <legend class="text-center">Inscription </legend>
            
			<p align="center"><i>Informations personnelles</i></p>
            
			<!-- nom-->
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
 
		     <!-- Pays-->
              <div class="form-group">
               <label class="col-md-3 control-label" for="pays">Pays </label>
		        <div class="col-md-6">
		         <select id="pays" name="pays" class="form-control required">
                  <option selected="selected"></option> 
				  <option value="Belgique">Belgique</option>
                  <option value="France">France</option>
                  <option value="Suisse">Suisse</option>
                  <option value="Pays-Bas">Pays-Bas</option>
                  <option value="Allemagne">Allemagne</option>
                 </select>
                </div>
              </div>
			
			<!-- Ville-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="ville">Ville</label>
              <div class="col-md-6">
                <input id="ville" name="ville" type="text" value="<?php if (isset($_POST['ville'])) echo htmlentities(trim($_POST['ville'])); ?>" 
				       placeholder="Ville de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Code postal-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="code_postal">Code postal</label>
              <div class="col-md-6">
                <input id="code_postal" name="code_postal" type="text" value="<?php if (isset($_POST['code_postal'])) echo htmlentities(trim($_POST['code_postal'])); ?>"
					   placeholder="Chiffres uniquement" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Date Naissance-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="date_naissance">Date de naissance</label>
              <div class="col-md-2">
                <input id="jour" name="jour" type="text" value="<?php if (isset($_POST['jour'])) echo htmlentities(trim($_POST['jour'])); ?>"
         			   class="form-control required" placeholder="Jour" role="input" aria-required="true"/> 
			  </div>
			  <div class="col-md-2">
				<input id="mois" name="mois" type="text" value="<?php if (isset($_POST['mois'])) echo htmlentities(trim($_POST['mois'])); ?>"
         			   class="form-control required" placeholder="Mois" role="input" aria-required="true"/> 
              </div>
			  <div class="col-md-2">			   
				<input id="année" name="année" type="text" value="<?php if (isset($_POST['année'])) echo htmlentities(trim($_POST['année'])); ?>"
         			   class="form-control required" placeholder="Année" role="input" aria-required="true"/>					   
              </div>
            </div>
			
			<p align="center"><i>Informations de connexion</i></p>
			
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
                <input id="mdp" name="mdp" type="password" placeholder="Mot de passe de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Confirmation Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="ConfirmMdp">Confirmation mot de passe</label>
              <div class="col-md-6">
                <input id="ConfirmMdp" name="ConfirmMdp" type="password" placeholder="Confirmation du mot de passe utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Email-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">Adresse Email</label>
              <div class="col-md-6">
                <input id="email" name="email" type="text" value="<?php if (isset($_POST['email'])) echo htmlentities(trim($_POST['email'])); ?>"
				       placeholder="Email de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Confirmation Email-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="ConfirmEmail">Confirmation adresse Email</label>
              <div class="col-md-6">
                <input id="ConfirmEmail" name="ConfirmEmail" type="text" value="<?php if (isset($_POST['ConfirmEmail'])) echo htmlentities(trim($_POST['ConfirmEmail'])); ?>" 
				       placeholder="Confirmation de l'adresse mail de l'utilisateur" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
			<!-- Lien URL Raspberry-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="LienRasp">Lien URL du raspberry</label>
              <div class="col-md-6">
                <input id="LienRasp" name="LienRasp" type="text" value="<?php if (isset($_POST['LienRasp'])) echo htmlentities(trim($_POST['LienRasp'])); ?>" 
				       placeholder="http://exemple.domaine:port/Raspberry" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>
			
            <!-- Bouton de validation -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="inscription" value="InscriptionUser" class="btn btn-primary btn-lg">Valider</button>
              </div>
            </div>
			
			<p align="center"><span class="label label-info">Tout les champs sont obligatoires</span></p>
			
			<?php include("inscription.php"); ?>
          </fieldset>
          </form>
        </div>  <!-- well -->
      </div>
	 </div>  <!-- row -->
      
	  <?php 
	  }
	   else
	    echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas administrateur. </div>
			   </div> <br/> <br/> <br/>';
	  }
	   else
	     echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
			   </div> <br/> <br/> <br/>';
			   
	  include("pied.inc.php"); ?>
    </body>
</html>