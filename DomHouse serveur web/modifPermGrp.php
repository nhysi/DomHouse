<?php
 session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Modification d'un groupe</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap-contact.js" type="text/javascript"></script>

    </head>
    
	<body>
     <?php include("entete.inc.php"); 
	  if(isset($_SESSION['login'])){
	  if($_SESSION['profil']== 1 || $_SESSION['profil']== 2){
	  if(isset($_GET['id_grp'])){
	  if(is_numeric($_GET['id_grp'])){
	  include("ConnectBDDRaspberry.php"); 
		//vérification de l'existence de ce groupe
		$sqlGrp = 'SELECT COUNT(*) FROM groupe WHERE idgroupe="'.mysqli_real_escape_string($linkRaspberry,$_GET['id_grp']).'"';
		$reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
		$dataGrp = mysqli_fetch_array($reqGrp,MYSQLI_NUM);
		mysqli_free_result($reqGrp);
		
		if($dataGrp[0] != 0){
		$sql = 'SELECT label,description FROM groupe WHERE idgroupe="'.mysqli_real_escape_string($linkRaspberry,$_GET['id_grp']).'"';
		$req = mysqli_query($linkRaspberry,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$data = mysqli_fetch_array($req,MYSQLI_NUM);
		mysqli_free_result($req);
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div class="well well-sm">
		<form role="form" class="form-horizontal" <?php echo 'action="modifPermGrp.php?id_grp='.$_GET['id_grp'].'"'; ?> method="post" id="contactform">
          <fieldset>
            <legend class="text-center">Modification d'un groupe</legend>
			
			 <!-- Nom du groupe-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="NomGrp">Nom du groupe</label>
              <div class="col-md-6">
                <input name="NomGrp" type="text" value="<?php echo $data[0]; ?>"
				       placeholder="Indiquez un nom" class="form-control required" role="input" aria-required="true"/>
              </div>
            </div>

			<!-- Description du groupe-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="descGrp">Description du groupe</label>
              <div class="col-md-6">
                <textarea name="descGrp" placeholder="Indiquez une description pour ce groupe" type="text" cols="50" rows="5" class="form-control required" role="input" aria-required="true">
				<?php echo $data[1]; ?></textarea>
              </div>
            </div>
			
			<?php echo '<p align="center"><span class="label label-info"> Modifier les permissions de groupe dont le groupe d\'utilisateur aura droit. </span></p>';
			 $sqlGrp = 'SELECT idEquip, label, categorie, piece FROM equipement';
			 $reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			 echo '<div class="table-responsive"> 
	               <table class="table table-condensed table-bordered table-stripped"><thead> 
				   <tr><th>Equipement</th><th>Catégorie</th><th>Pièce</th><th>Permissions</th></tr></thead>';
			 while($rowGrp = mysqli_fetch_array($reqGrp,MYSQLI_ASSOC)){
			    //permissions equipement du groupe
			    $sqlIdGrp = 'SELECT idEquip, acces FROM eq_grp WHERE idGrp = "'.mysqli_real_escape_string($linkRaspberry,$_GET['id_grp']).'"';
			    $reqIdGrp = mysqli_query($linkRaspberry,$sqlIdGrp) or die('Erreur SQL !<br />'.$sqlIdGrp.'<br />'.mysql_error());
				$acces = null;
			    $ok = null;
			   
			   echo '<tr><td><input type="checkbox" id="'.$rowGrp['idEquip'].'" name="'.$rowGrp['idEquip'].'" value="'.$rowGrp['idEquip'].'"'; while($rowIdGrp = mysqli_fetch_array($reqIdGrp,MYSQLI_NUM)){
				 $idEquipement = $rowIdGrp[0];
				 $access = $rowIdGrp[1];
				 if($idEquipement == $rowGrp['idEquip']){ echo 'checked="checked"'; $Ok = 1; $acces = $access;}
				}
				 echo'/>  
					<label for="'.$rowGrp['idEquip'].'">'.$rowGrp['label'].'</label></td><td>'.$rowGrp['categorie'].'</td><td>'.$rowGrp['piece'].'</td>';
					if(isset($Ok) && $acces == 0) echo '<td><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="0" checked="checked">lecture<br/><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="1">modification</td>';
					elseif(isset($Ok) && $acces == 1) echo '<td><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="0">lecture<br/><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="1" checked="checked">modification</td>';
					else echo '<td><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="0" checked="checked">lecture<br/><input type= "radio" name="Grp'.$rowGrp['idEquip'].'" value="1">modification</td>';
					echo '</tr>';
					
			   }
			 echo '</table></div>'; 
			 mysqli_free_result($reqIdGrp);
			 mysqli_free_result($reqGrp);
			?>
			
			<!-- Bouton de validation -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="modifGrp" value="modificationGroupe" id="bouton-search">Valider</button>
              </div>
            </div>
			<?php
			 if (isset($_POST['modifGrp']) && $_POST['modifGrp'] == 'modificationGroupe') {
			// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
			if (!empty($_POST['NomGrp']) && !empty($_POST['descGrp'])){
			 //on vérifie que le nom de groupe n'est pas déjà utilisé
			$sql = 'SELECT COUNT(*) FROM groupe WHERE label="'.mysqli_real_escape_string($linkRaspberry,$_POST['NomGrp']).'"';
			$req = mysqli_query($linkRaspberry,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			$data = mysqli_fetch_array($req,MYSQLI_NUM);
					
			//suppression des anciennes permissions de groupes dans la table eq_grp
			$sqldel = 'DELETE FROM eq_grp WHERE idGrp ="'.mysqli_real_escape_string($linkRaspberry,$_GET['id_grp']).'"';
			mysqli_query($linkRaspberry,$sqldel) or die('Erreur SQL !'.$sqldel.'<br />'.mysql_error());
			
			//recup checkbox et insertion des nouvelles permissions de groupe dans la table eq_grp du raspberry
			$sql8 = 'SELECT idEquip FROM equipement';
			$req8 = mysqli_query($linkRaspberry,$sql8) or die('Erreur SQL !<br />'.$sql8.'<br />'.mysql_error());
			while($check = mysqli_fetch_array($req8,MYSQLI_NUM)){
			if(!empty($_POST[$check[0]])){ 
				$sql9 = 'INSERT INTO eq_grp VALUES("'.$_POST[$check[0]].'","'.$_GET['id_grp'].'","'.$_POST['Grp'.$check[0].''].'")';
				mysqli_query($linkRaspberry,$sql9) or die('Erreur SQL !'.$sql9.'<br />'.mysql_error());
			   }
			}
		    mysqli_free_result($req8);
			$succes = 'Groupe modifié avec succès!';		
			 echo '<script language="Javascript">
			<!--
			document.location.replace("redirect.php?msg='.$succes.'");
			// -->
			</script>';
			}
			else 
			 echo '<div class="alert alert-danger" role="alert" align="center">Nom de groupe déjà existant!</div>';
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
		        <div class="alert alert-danger" role="alert" align="center"> Id de groupe inconnu. </div>
			   </div> <br/> <br/> <br/>';
	 }
	  else
		echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Tentative d\'injection sql détecté. </div>
			   </div> <br/> <br/> <br/>';
	 }
	  else
		echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Aucun id de groupe indiqué. </div>
			   </div> <br/> <br/> <br/>';
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