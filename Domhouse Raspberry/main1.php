<?php

require_once('configuration.php');
require_once('functions.php');
include('connect.php');

?>
<!doctype html>
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Dom'House</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">

</head> 
<body>

<?php

$idUser = $_GET['u_id'];
$login = $_GET['login'];
$mdp = $_GET['mdp'];
$piece= $_GET['piece'];

?>

<div class="tab">
	<h2>  Tous les objets contrôlables  </h2>
	<table class="materialTab">
		<tr>
			<th>Objet</th>
			<th>PIN</th>
			<th>Etat</th>
		</tr><?php 	
		$sql = 'SELECT * FROM equipement WHERE piece = "'.$piece.'" ORDER by label';
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		while ($data = mysql_fetch_array($req)) { ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['Pins']; ?></td>
				
				<?php
				if($data['Pins']==11) {
					$on =1; $off =0;?>
					<td>
						<div onclick="changeState2(<?php echo $on; ?>)" class="pinState2"> </div>
											
						<div onclick="changeState2(<?php echo $off; ?>)" class="pinState3"> </div>
					</td><?php 
				} 
				else
				{
				
					$pinState = getPinState($data['Pins'],$pins); ?> 
					<td>
						<?phpif($data["statut"] = 1){ ?><div onclick="changeState(<?php echo $data['Pins']; ?>,this)" class="pinState <?php echo $pinState; ?>"></div>
					    <?php}else {echo $pinState;} ?>
					</td>
			</tr>
			<?php
		} ?>
	</table> <br/><br/>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>

		
		
<?php //Fermture de la connexion a la BDD
	mysql_free_result ($req);
	mysql_close (); 
?>