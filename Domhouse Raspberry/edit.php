<?php
if(isset($_GET['idEquip'])){ ?>
 
 <!doctype html>
  <html class="no-js" lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>DomHouse : Edition des équipements</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">
  </head> 
  <body>
  <?php
  
  if(is_numeric($_GET['idEquip'])){
  if((isset($_GET['u_id']) && is_numeric($_GET['u_id'])) || !isset($_GET['u_id'])){
  $id_equip = ($_GET['idEquip']);
  include('connect.php');
  $sql = 'SELECT label,Pins,NumeroRadio,categorie,piece FROM equipement WHERE idEquip = "'.$id_equip.'"';
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
  $data = mysql_fetch_array($req);
  mysql_free_result($req);
  ?>
  <h2> Modification d'un équipement </h2>
  <div id="edit">
   <br/>
   <?php echo'<form class="form-horizontal" action="edit.php?idEquip='.urlencode($id_equip).'" method="post">';?>	
	<label for="login">Label:</label>
    <input name="label" type="text" value="<?php if(isset($data['label'])) echo htmlentities(trim($data['label']));?>" placeholder="Indiquez un nouveau nom d'équipement"><br/>
	
    <div align="center">
     <button id="bouton" type="submit" name="editOK" value="Edition-Label">Valider</button>
    </div>
	
   </form>
   
   <?php echo'<form class="form-horizontal" action="edit.php?idEquip='.urlencode($id_equip).'" method="post">';?>
	
	<label for="login">Numéro-Radio:</label>
    <input name="NumRad" type="text" value="<?php if(isset($data['NumeroRadio'])) echo htmlentities(trim($data['NumeroRadio']));?>" placeholder="Indiquez un nouveau numéro radio"><br/>
	
    <div align="center">
     <button id="bouton" type="submit" name="editOK" value="Edition-NumRad">Valider</button>
    </div>
	
   </form>   
   
   <?php echo'<form class="form-horizontal" action="edit.php?idEquip='.urlencode($id_equip).'" method="post">';?>
	
	<label for="login">PIN:</label>
    <input name="PIN" type="text" value="<?php if(isset($data['Pins'])) echo htmlentities(trim($data['Pins']));?>" placeholder="Indiquez un nouveau numéro de PIN"><br/>
	
    <div align="center">
     <button id="bouton" type="submit" name="editOK" value="Edition-PIN">Valider</button>
    </div>
	
   </form>
   
  <?php
  if(isset($_POST['editOK']) && $_POST['editOK'] == 'Edition-Label'){
    if(!empty($_POST['label'])){
	 $sqlUp = 'UPDATE equipement SET label = "'.mysql_real_escape_string($_POST['label']).'" WHERE idEquip = "'.$id_equip.'"';
	 $reqUp = mysql_query($sqlUp) or die('Erreur SQL !<br />'.$sqlUp.'<br />'.mysql_error());
	 mysql_free_result($reqUp);
	 mysql_close();
	 echo '<font align="center" color="green">Modification du label réussi!</font>';
	  echo '<script language="Javascript">
			setTimeout(document.location.replace("edit.php?idEquip='.urlencode($id_equip).'"), 2000 );
			</script>';
	}
	else
	 echo 'Champ vide';
  }
  
  if(isset($_POST['editOK']) && $_POST['editOK'] == 'Edition-NumRad'){
    if(!empty($_POST['NumRad'])){
	 $sqlUp = 'UPDATE equipement SET NumeroRadio = "'.mysql_real_escape_string($_POST['NumRad']).'" WHERE idEquip = "'.$id_equip.'"';
	 $reqUp = mysql_query($sqlUp) or die('Erreur SQL !<br />'.$sqlUp.'<br />'.mysql_error());
	 mysql_free_result($reqUp);
	 mysql_close();
	 echo '<font align="center" color="green">Modification du numéro radio réussi!</font>';
	  echo '<script language="Javascript">
			document.location.replace("edit.php?idEquip='.urlencode($id_equip).'");
			</script>';
	}
	else
	 echo 'Champ vide';
  }
  
  if(isset($_POST['editOK']) && $_POST['editOK'] == 'Edition-PIN'){
    if(!empty($_POST['PIN'])){
	 $sqlUp = 'UPDATE equipement SET Pins = "'.mysql_real_escape_string($_POST['PIN']).'" WHERE idEquip = "'.$id_equip.'"';
	 $reqUp = mysql_query($sqlUp) or die('Erreur SQL !<br />'.$sqlUp.'<br />'.mysql_error());
	 mysql_free_result($reqUp);
	 mysql_close();
	 echo '<font align="center" color="green">Modification du PIN réussi!</font>';
	  echo '<script language="Javascript">
			document.location.replace("edit.php?idEquip='.urlencode($id_equip).'");
			</script>';
	}
	else
	 echo 'Champ vide'; 
  }  
   echo '</div>';
   echo '<a href="index.php?u_id='.urlencode($_GET['u_id']).'">Revenir au panel de gestion des équipements</a><br>';
   echo '<a href="mainboard.php">Revenir à la page personnelle</a>';
  }
  }
   else
    echo 'u_id et/ou idEquip inconnu.';
 }
else
 echo 'Aucun id d\'équipement n\'a été specifié';
?>
</body>
</html>