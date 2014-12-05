<?php


 // if(!empty($idUser) && !empty($login) && !empty($mdp)){
/*
$sql = 'SELECT count(*) FROM utilisateur WHERE User_ID="'.mysqli_real_escape_string($link,$idUser).'", login="'.mysqli_real_escape_string($link,$login).'" AND mdp="'.mysqli_real_escape_string($link,$mdp).'"';
$req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.mysql_error());
$data = mysqli_fetch_array($req,MYSQLI_NUM);

if($data[0] == 1){*/ //il y a une correspondance


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
	<title>Dom'House : Panel de Gestion</title>
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
			<th>Etat</th>
		</tr><?php 	
		$sql = 'SELECT label,Pins,NumeroRadio FROM equipement WHERE statut = "1" ORDER by Pins';
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		while ($data = mysql_fetch_array($req)) { ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td> <?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; ?>,<?php echo $data['NumeroRadio']; ?>)" class="pinState2"> </div>
						<div onclick="changeState2(<?php echo $off; ?>,<?php echo $data['NumeroRadio']; ?>)" class="pinState3"> </div>
					</td><?php 
				} 
				else
				{
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td>
						<div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div>
					</td><?php 
				}?>
			</tr><?php
		} ?>
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
			<th>Pièce</th>
			<th>Etat</th>
		</tr><?php 	 $ip=$_SERVER["REMOTE_ADDR"];
		$sql = 'SELECT label,Pins,NumeroRadio FROM equipement WHERE caract = "Relay" && label = "Libre"';
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		while ($data = mysql_fetch_array($req))
		{ ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins'];?></td> <?php
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
				}?>
			</tr><? 
		} ?>
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
<?php
// } else echo 'Accès non autorisé'; ?>
		
		
<?php //Fermture de la connexion a la BDD
	mysql_free_result ($req);
	mysql_close (); 
?>