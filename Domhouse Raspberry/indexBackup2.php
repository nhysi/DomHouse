<?php
$idUser = $_GET['u_id'];

if((isset($idUser) && is_numeric($idUser)) || (!isset($idUser)) || (empty($idUser))){

require_once('configuration.php');
require_once('functions.php');
include('connect.php');
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>DomHouse : Panel de Gestion</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">

</head> 
<body>

<!-- Ici c'est le tableau des objets qui sont branchés au Raspberry et qui sont donc contrôlables, ce n'est donc PAS les objets "allumés/éteints" mais juste les objets pouvant être contrôlés -->
<div class="tab">
	<h2>  Tous les objets contrôlables  </h2>
	<table class="materialTab">
		<tr>
			<th>Objet</th>
			<th>PIN</th>
			<th>Catégorie</th>
			<th>Pièce</th>
			<th>Etat</th>
			<th>Action</th>
		</tr><?php 	
		//requetes pour les permissions
										
		//permissions individuelles
		$sqlSelect1 = 'SELECT COUNT(*) FROM user_eq WHERE idUser="'.$idUser.'"';
		$reqSelect1 = mysql_query($sqlSelect1);
		$dataSelect1 = mysql_fetch_array($reqSelect1);
		mysqli_free_result($reqSelect1); 

		if($dataSelect1[0] != 0){
		$sqlSelect2 = 'SELECT idEquip FROM user_eq WHERE idUser="'.$idUser.'"';
		$reqSelect2 = mysql_query($sqlSelect2);
		while($dataSelect2 = mysql_fetch_array($reqSelect2)){
		 $sql = 'SELECT label,Pins,NumeroRadio,categorie,piece FROM equipement WHERE statut = "1" AND idEquip="'.$dataSelect2[0].'"';
		 $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		 $data = mysql_fetch_array($req); 
		 if($data['label'] != null){
		 ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; echo $data['NumeroRadio'];?></td>
				<?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; echo $data['NumeroRadio'];?>)" class="pinState22"> </div>				
						<div onclick="changeState2(<?php echo $off; echo $data['NumeroRadio'];?>)" class="pinState3"> </div>
					</td><?php 
				} 
				else
				{
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td>
						<div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div>
					</td><?php 
				}
			echo '<td><a href="edit.php?idEquip='.urlencode($dataSelect2[0]).'&u_id='.urlencode($idUser).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			echo '</tr>';
		 }
        }
		}
		else{ //sinon permissions de groupe ou utilisateur primaire
         $sqlSelect3 = 'SELECT COUNT(*) FROM userGrp WHERE idUser="'.$idUser.'"';
		 $reqSelect3 = mysql_query($sqlSelect3);
		 $dataSelect3 = mysql_fetch_array($reqSelect3);
		 mysqli_free_result($reqSelect3);
			if($dataSelect3[0] != 0){ //permissions de groupe
			 $sqlSelect4 = 'SELECT idGrp FROM userGrp WHERE idUser="'.$idUser.'"';
		     $reqSelect4 = mysql_query($sqlSelect4);
		     $dataSelect4 = mysql_fetch_array($reqSelect4);
		     mysqli_free_result($reqSelect4);
			 
			 $sqlSelect5 = 'SELECT idEquip FROM eq_grp WHERE idGrp="'.$dataSelect4[0].'"';
		     $reqSelect5 = mysql_query($sqlSelect5);
		     while($dataSelect5 = mysql_fetch_array($reqSelect5)){
			  $sql = 'SELECT label,Pins,NumeroRadio, categorie, piece FROM equipement WHERE statut = "1" AND idEquip="'.$dataSelect5[0].'"';
		      $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		      $data = mysql_fetch_array($req);
			  if($data['label'] != null){ ?>
			  <tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; ?></td><?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; echo $data['NumeroRadio'];?>)" class="pinState22"> </div>									
						<div onclick="changeState2(<?php echo $off; echo $data['NumeroRadio'];?>)" class="pinState3"> </div>
					</td><?php 
				} 
				else
				{
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td>
						<div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div>
					</td><?php 
				}
			   echo '<td><a href="edit.php?idEquip='.urlencode($dataSelect5[0]).'&u_id='.urlencode($idUser).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			   echo '</tr>';
			 }
			 }
		     mysqli_free_result($reqSelect5);
			}
			else{//sinon utilisateur primaire
			 $sql = 'SELECT idEquip,label,Pins,NumeroRadio, categorie, piece FROM equipement WHERE statut = "1"';
		     $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		     while($data = mysql_fetch_array($req)){ ?>
			 <tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td> 
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; echo $data['NumeroRadio'];?></td>
				<?php	
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on;  echo $data['NumeroRadio'];?>)" class="pinState2"> </div>					
						<div onclick="changeState2(<?php echo $off;  echo $data['NumeroRadio'];?>)" class="pinState3"> </div>
					</td><?php 
				} 
				else
				{
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td>
						<div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div>
					</td><?php 
				}
			echo '<td><a href="edit.php?idEquip='.urlencode($data['idEquip']).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			echo '</tr>';
			}
			
			}
		}

?>
	</table> <br/><br/>
</div>
<!--
<div class="video">
	<h2> Streaming </h2>
	<video width="356" height="200" controls>
		<source src="http://domhouse.zapto.org:8080" type="video/mp4"/>
		<source src="http://domhouse.zapto.org:8080" type="video/ogg"/>
		<source src="http://domhouse.zapto.org:8080" type="video/webm"/> 
		<em>Sorry, your browser doesn't support HTML5 video.</em>
	</video> 
</div>
-->

<!-- Ici ce sont toutes les sorties permettant de contrôler les objets, ce sont donc toutes les sorties, connectées ou non a un objet -->
<div class="tab">
	<h2> Les entrées libres sur le Relay  </h2>
	<table class="materialTab">
		<tr>
			<th>Objet</th>
			<th>PIN</th>
			<th>Catégorie</th>
			<th>Pièce</th>
			<th>Etat</th>
			<th>Action</th>
		<?php 	
		//requetes pour les permissions
										
		//permissions individuelles
		$sqlSelect1 = 'SELECT COUNT(*) FROM user_eq WHERE idUser="'.$idUser.'"';
		$reqSelect1 = mysql_query($sqlSelect1);
		$dataSelect1 = mysql_fetch_array($reqSelect1);
		mysqli_free_result($reqSelect1); 

		if($dataSelect1[0] != 0){
		$sqlSelect2 = 'SELECT idEquip FROM user_eq WHERE idUser="'.$idUser.'"';
		$reqSelect2 = mysql_query($sqlSelect2);
		while($dataSelect2 = mysql_fetch_array($reqSelect2)){
		 $sql = 'SELECT label,Pins,NumeroRadio,categorie,piece FROM equipement WHERE caract = "Relay" && label = "Libre" && idEquip="'.$dataSelect2[0].'"';
		 $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		 $data = mysql_fetch_array($req); 
		 if($data['label'] != null){
		 ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; ?></td>
				<?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; ?>,this)" class="pinState2"> </div>
						<div onclick="changeState2(<?php echo $off; ?>,this)" class="pinState3"> </div>
					</td><?php 
				} 
				else {
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td><div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div></td> <?php 
				}
			echo '<td><a href="edit.php?idEquip='.urlencode($dataSelect2[0]).'&u_id='.urlencode($idUser).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			echo '</tr>';
		  }
		 }
		}
		else{ //sinon permissions de groupe ou utilisateur primaire
         $sqlSelect3 = 'SELECT COUNT(*) FROM userGrp WHERE idUser="'.$idUser.'"';
		 $reqSelect3 = mysql_query($sqlSelect3);
		 $dataSelect3 = mysql_fetch_array($reqSelect3);
		 mysqli_free_result($reqSelect3);
			if($dataSelect3[0] != 0){ //permissions de groupe
			 $sqlSelect4 = 'SELECT idGrp FROM userGrp WHERE idUser="'.$idUser.'"';
		     $reqSelect4 = mysql_query($sqlSelect4);
		     $dataSelect4 = mysql_fetch_array($reqSelect4);
		     mysqli_free_result($reqSelect4);
			 
			 $sqlSelect5 = 'SELECT idEquip FROM eq_grp WHERE idGrp="'.$dataSelect4[0].'"';
		     $reqSelect5 = mysql_query($sqlSelect5);
		     while($dataSelect5 = mysql_fetch_array($reqSelect5)){
			  $sql = 'SELECT label,Pins,NumeroRadio, categorie, piece FROM equipement WHERE caract = "Relay" && label = "Libre" && idEquip="'.$dataSelect5[0].'"';
		      $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		      $data = mysql_fetch_array($req);
			  if($data['label'] != null){ ?>
			  
			  <tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; ?></td>
				<?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; ?>,this)" class="pinState2"> </div>
						<div onclick="changeState2(<?php echo $off; ?>,this)" class="pinState3"> </div>
					</td><?php 
				} 
				else {
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td><div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div></td> <?php 
				}
			echo '<td><a href="edit.php?idEquip='.urlencode($dataSelect5[0]).'&u_id='.urlencode($idUser).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			echo '</tr>';
		       }     
			  
			 }
		     mysqli_free_result($reqSelect5);
			}
			else{//sinon utilisateur primaire
			 $sql = 'SELECT idEquip,label,Pins,NumeroRadio, categorie, piece FROM equipement WHERE caract = "Relay" && label = "Libre"';
		     $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		     while($data = mysql_fetch_array($req)){ ?>
			 <tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				<td><?php echo $data['categorie']; ?></td>
				<td><?php echo $data['piece']; ?></td>
				<?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; ?>,this)" class="pinState2"> </div>
						<div onclick="changeState2(<?php echo $off; ?>,this)" class="pinState3"> </div>
					</td><?php 
				} 
				else {
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td><div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div></td> <?php 
				}
			echo '<td><a href="edit.php?idEquip='.urlencode($data[0]).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			echo '</tr>';
			 }
			
			}
		}?>
	</table>
</div>

<!--
<div class="video">
	<h2> Streaming </h2>
	<video width="356" height="200" controls>
		<source src="http://192.168.1.7:8080" type="video/mp4"/>
		<source src="http://192.168.1.7:8080" type="video/ogg"/>
		<source src="http://192.168.1.7:8080" type="video/webm"/>
		<em>Sorry, your browser doesn't support HTML5 video.</em>
	</video> 
</div>
-->

<script src="js/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
	
<?php //Fermture de la connexion a la BDD
	mysql_free_result ($req);
	mysql_close (); 
}
else echo 'Refusé';	
?>