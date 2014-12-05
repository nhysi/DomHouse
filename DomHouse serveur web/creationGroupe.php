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
	  if($_SESSION['profil']== 2){
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div class="well well-sm">
		<form role="form" class="form-horizontal" action="creationGroupe.php" method="post" id="contactform">
          <fieldset>
			<legend class="text-center">Création d'un groupe</legend>
			<?php include('ConnectBDDRaspberry.php'); ?>
			<form role="form" class="form-horizontal" action="creationGroupe.php" method="post" id="contactform">
	        <!-- Nom du groupe-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="NomGrp">Nom du groupe</label>
              <div class="col-md-6">
                <input size="20" name="NomGrp" type="text" value="<?php if (isset($_POST['NomGrp'])) echo htmlentities(trim($_POST['NomGrp'])); ?>"
				       placeholder="Indiquez un nom" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>

			<!-- Description du groupe-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="descGrp">Description du groupe</label>
              <div class="col-md-6">
                <textarea name="descGrp" placeholder="Indiquez une description pour ce groupe" type="text" cols="50" rows="5" class="form-control required" role="input" aria-required="true">
				<?php if (isset($_POST['descGrp'])) echo htmlentities(trim($_POST['descGrp'])); ?></textarea>
              </div>
            </div>
			
			<!-- Permissions du groupe-->
            <?php echo '<p align="center"><span class="label label-info"> Cocher les équipements dont le groupe d\'utilisateur aura droit. </span></p>';
			echo '<div>';
			$sqlGrp = 'SELECT idEquip, label, categorie, piece FROM equipement';
			$reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			echo '<table id="tabperm" border="1" align="center"><tr><th>Equipement</th><th>Catégorie</th><th>Pièce</th><th>Permissions</th></tr>';
			while($rowGrp = mysqli_fetch_array($reqGrp,MYSQLI_ASSOC)){
			  echo '<tr><td><input type="checkbox" id="'.$rowGrp['idEquip'].'" name="'.$rowGrp['idEquip'].'" value="'.$rowGrp['idEquip'].'"/>  
					<label for="'.$rowGrp['idEquip'].'">'.$rowGrp['label'].'</label></td><td>'.$rowGrp['categorie'].'</td><td>'.$rowGrp['piece'].'</td>
					<td><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="0" checked="checked">lecture<br/><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="1">modification</td></tr>';
			  }	
			echo '</div>';
			echo '</table>'; 
			mysqli_free_result($reqGrp);
			?>
			<br/>
			<div class="form-group">
			 <div align="center">
              <button type="submit" name="GroupeCreate" value="CreationDeGroupe" id="bouton-search">Créer groupe</button>
             </div>
			</div>
        <?php
			if (isset($_POST['GroupeCreate']) && $_POST['GroupeCreate'] == 'CreationDeGroupe') {
			// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
			if (!empty($_POST['NomGrp']) && !empty($_POST['descGrp'])){
			
			//on vérifie que le nom de groupe n'est pas déjà utilisé
			$sql = 'SELECT COUNT(*) FROM groupe WHERE label="'.mysqli_real_escape_string($linkRaspberry,$_POST['NomGrp']).'"';
			$req = mysqli_query($linkRaspberry,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			$data = mysqli_fetch_array($req,MYSQLI_NUM);
			
			if($data[0] == 0){//si aucun groupe ayant ce nom n'existe
			//on insere les données du nouveau groupe dans la table groupe
			$sql4 = 'INSERT INTO groupe VALUES("'.
			mysqli_insert_id($linkRaspberry).'","'.mysqli_real_escape_string($linkRaspberry,$_POST['NomGrp']).'",
			"'.mysqli_real_escape_string($linkRaspberry,($_POST['descGrp'])).'")';
			mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !'.$sql4.'<br />'.mysql_error());
			
			//on recup l'id du groupe
			$sql6 = 'SELECT idgroupe FROM groupe WHERE label="'.mysqli_real_escape_string($linkRaspberry,$_POST['NomGrp']).'"';
			$req6 = mysqli_query($linkRaspberry,$sql6) or die('Erreur SQL !<br />'.$sql6.'<br />'.mysql_error());
			$data6 = mysqli_fetch_array($req6,MYSQLI_NUM);
			mysqli_free_result($req6);
	   			
			//recup checkbox et insertion des permission individuelles dans la table eq_grp du raspberry
			$sql8 = 'SELECT idEquip FROM equipement';
			$req8 = mysqli_query($linkRaspberry,$sql8) or die('Erreur SQL !<br />'.$sql8.'<br />'.mysql_error());
			while($check = mysqli_fetch_array($req8,MYSQLI_NUM)){
			if(!empty($_POST[$check[0]])){ 
				$sql9 = 'INSERT INTO eq_grp VALUES("'.$_POST[$check[0]].'","'.$data6[0].'","'.$_POST['Grp'.$check[0].''].'")';
				mysqli_query($linkRaspberry,$sql9) or die('Erreur SQL !'.$sql9.'<br />'.mysql_error());
			   }
			}
		    mysqli_free_result($req8);
			$succes = 'Groupe créé avec succès!';		
			 echo '<script language="Javascript">
			<!--
			document.location.replace("redirect.php?msg='.$succes.'");
			// -->
			</script>';
			}
			echo '<div class="alert alert-danger" role="alert" align="center">Nom de groupe déjà existant!</div>';
			}
			else
			echo 'Nom ou description groupe ou permissions manquantes';
			}
		?>
			</fieldset>
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