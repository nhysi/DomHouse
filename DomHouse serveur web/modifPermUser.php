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
	  if(isset($_GET['u_id'])){
	  if(is_numeric($_GET['u_id'])){
	  include("ConnectBDDRaspberry.php"); 
		//vérification de l'existence de ce groupe
		$sqlUser = 'SELECT COUNT(*) FROM user WHERE idUser="'.mysqli_real_escape_string($linkRaspberry,$_GET['u_id']).'"';
		$reqUser = mysqli_query($linkRaspberry,$sqlUser) or die('Erreur SQL !<br />'.$sqlUser.'<br />'.mysql_error());
		$dataUser = mysqli_fetch_array($reqUser,MYSQLI_NUM);
		mysqli_free_result($reqUser);
		
		if($dataUser[0] != 0){
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-8 col-md-offset-2">
        <div class="well well-sm">
		<form role="form" class="form-horizontal" <?php echo 'action="modifPermUser.php?u_id='.$_GET['u_id'].'"'; ?> method="post" id="contactform">
          <fieldset>
            <legend class="text-center">Modification des permissions utilisateur</legend>
				
			<?php echo '<p align="center"><span class="label label-info"> Modifier les permissions dont l\'utilisateur aura droit. </span></p>';
			 $sqlUser = 'SELECT idEquip, label, categorie, piece FROM equipement';
			 $reqUser = mysqli_query($linkRaspberry,$sqlUser) or die('Erreur SQL !<br />'.$sqlUser.'<br />'.mysql_error());
			 echo '<div class="table-responsive"> 
	               <table class="table table-condensed table-bordered table-stripped"><thead> 
				   <tr><th>Equipement</th><th>Catégorie</th><th>Pièce</th><th>Permissions</th></tr></thead>';
			 while($rowUser = mysqli_fetch_array($reqUser,MYSQLI_ASSOC)){
			    //permissions equipement de l'utilisateur
			    $sqlIdUser = 'SELECT idEquip, acces FROM user_eq WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$_GET['u_id']).'"';
			    $reqIdUser = mysqli_query($linkRaspberry,$sqlIdUser) or die('Erreur SQL !<br />'.$sqlIdUser.'<br />'.mysql_error());
				$acces = null;
			    $ok = null;
			   
			   echo '<tr><td><input type="checkbox" id="'.$rowUser['idEquip'].'" name="'.$rowUser['idEquip'].'" value="'.$rowUser['idEquip'].'"'; while($rowIdUser = mysqli_fetch_array($reqIdUser,MYSQLI_NUM)){
				 $idEquipement = $rowIdUser[0];
				 $access = $rowIdUser[1];
				 if($idEquipement == $rowUser['idEquip']){ echo 'checked="checked"'; $Ok = 1; $acces = $access;}
				}
				 echo'/>  
					<label for="'.$rowUser['idEquip'].'">'.$rowUser['label'].'</label></td><td>'.$rowUser['categorie'].'</td><td>'.$rowUser['piece'].'</td>';
					if(isset($Ok) && $acces == 0) echo '<td><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="0" checked="checked">lecture<br/><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="1">modification</td>';
					elseif(isset($Ok) && $acces == 1) echo '<td><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="0">lecture<br/><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="1" checked="checked">modification</td>';
					else echo '<td><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="0" checked="checked">lecture<br/><input type= "radio" name="Grp'.$rowUser['idEquip'].'" value="1">modification</td>';
					echo '</tr>';
					
			   }
			 echo '</table></div>'; 
			 mysqli_free_result($reqIdUser);
			 mysqli_free_result($reqUser);
			?>
			
			<!-- Bouton de validation -->
            <div class="form-group">
              <div align="center">
                <button type="submit" name="modifPermUser" value="modificationPermUser" id="bouton-search">Valider</button>
              </div>
            </div>
			<?php
			 if (isset($_POST['modifPermUser']) && $_POST['modifPermUser'] == 'modificationPermUser'){		
			//suppression des anciennes permissions de l'utilisateur dans la table user_eq
			$sqldel = 'DELETE FROM user_eq WHERE idUser ="'.mysqli_real_escape_string($linkRaspberry,$_GET['u_id']).'"';
			mysqli_query($linkRaspberry,$sqldel) or die('Erreur SQL !'.$sqldel.'<br />'.mysql_error());
			
			//recup checkbox et insertion des nouvelles permissions de l'utilisateur dans la table user_eq du raspberry
			$sql8 = 'SELECT idEquip FROM equipement';
			$req8 = mysqli_query($linkRaspberry,$sql8) or die('Erreur SQL !<br />'.$sql8.'<br />'.mysql_error());
			while($check = mysqli_fetch_array($req8,MYSQLI_NUM)){
			if(!empty($_POST[$check[0]])){ 
				$sql9 = 'INSERT INTO user_eq VALUES("'.$_GET['u_id'].'","'.$_POST[$check[0]].'","'.$_POST['Grp'.$check[0].''].'")';
				mysqli_query($linkRaspberry,$sql9) or die('Erreur SQL !'.$sql9.'<br />'.mysql_error());
			   }
			}
		    mysqli_free_result($req8);
			$succes = 'Permissions de l\'utilisateur modifiées avec succès!';		
			 echo '<script language="Javascript">
			<!--
			document.location.replace("redirect.php?msg='.$succes.'");
			// -->
			</script>';
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