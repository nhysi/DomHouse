<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Dom'House : Panel de Gestion</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="Css/css.css">
	</head> 
	<?php
	require_once('Fonctions.php');
	include('connect.php');
	?>
<body>
	<?php
	$on = 1; $off= 0;
	$query = 'SELECT label,NumeroRadio,caract,piece,Pins FROM equipement WHERE statut = "1"';
	$req = mysql_query($query) or die('Erreur SQL !<br />'.$query.'<br />'.mysql_error());
	while($item = mysql_fetch_array($req))
	{ ?>
		<div class="Cadre_Cadre_Objet">	
			<div class="Cadre_Objet">
				<div class="Cadre_Titre_Objet">
					<div class="Titre_Objet"><?php echo $item[0];?></div>
				</div>
				<div class="Cadre_Photo_Objet">
					<img class="Photo_Objet" src="img/lampe.jpg">
				</div>
				<div class="Cadre_Info_Objet">
					<div class="Titre_Info_Objet"> Pièce</div>:<div class="Info_Objet"> <?php echo $item[3];?> </div><br/>
					<div class="Titre_Info_Objet"> Etat </div>:<div class="Info_Objet"> <?php if($item[2] == "Relay") echo getPinState($item[1],$pins);?> </div>
				</div>
				<div class="Cadre_Commande_Objet">
					<div onclick="changeState2(<?php echo $on; ?>,<?php echo $item[1]; ?>)" class="pinState2"> </div>
					<div onclick="changeState2(<?php echo $off; ?>,<?php echo $item[1]; ?>)" class="pinState3"> </div>
				</div>
			</div>
		</div><?php
	}
	mysql_free_result($req);
	Deco($link);
	?>
	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>
