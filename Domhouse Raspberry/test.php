<?php
require_once('configuration.php');
require_once('functions.php');
include('connect.php');
?>

<!doctype html>

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
<?php 


$idUser = $_GET['u_id'];
$login = $_GET['login'];
$mdp = $_GET['mdp'];
$piece= $_GET['piece'];


	  echo '<h2>  Tous les objets contrôlables  </h2>';
	  echo '<h3>'.$piece.'</h3>'; 
?> 
	
	<table class="materialTab">
		<tr>
			<th>Objet</th>
			<th>Info</th>
			<th>Piece</th>
			<th>Etat</th>
			<th>Action</th>
			
		</tr><?php 
	     $sql = 'SELECT * FROM equipement WHERE piece = "'.$piece.'" and statut = "1" ORDER by label';
		
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		while ($data = mysql_fetch_array($req)) { ?>
			<tr>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['caract']; ?></td> 
				<td><?php echo $data['piece']; ?></td> 
				<?php
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
				}
				echo '<td><a href="edit.php?idEquip='.urlencode($data['idEquip']).'&u_id='.urlencode($idUser).'"><img src="img/modifier.png" title="Editer" alt="Edition" width="30px" height="30px" /></a></td>';
			?></tr><?php
		} ?>
	</table> <br/><br/>

</div>

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