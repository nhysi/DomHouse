<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Connexion</title>
    </head>
 
    <body>	  
	  <?php include('entete.inc.php'); ?>
      
      <br/>
	  <div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="well">
			 <form class="form-horizontal" action="connexion.php" method="post">
               <legend class="text-center">Connectez-vous à votre panel</legend>
    
               <!-- Login-->
               <div class="form-group">
                <label class="col-md-3 control-label" for="login">Login</label>
              <div class="col-md-6">
                <input name="login" type="text" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login']));?>" type="text" placeholder="Votre identifiant" class="form-control">
              </div>
            </div>
    
            <!-- Mdp-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="mdp">Mot de passe</label>
              <div class="col-md-6">
                <input name="mdp" type="password" placeholder="Votre mot de passe" class="form-control">
              </div>
            </div>
               
            <!-- Bouton -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="connexion" value="Connexion" class="btn btn-primary btn-lg">Connexion</button>
              </div>
            </div>
          </form>
		  <?php include('login.php');
           echo '<br/>';
           if(isset($erreur)) echo $erreur;
		  ?>
        </div>  <!-- well -->
      </div>
	 </div>  <!-- row -->
	 <br/>
	 
	<?php include('pied.inc.php'); ?>
	 
	</body>  
</html>