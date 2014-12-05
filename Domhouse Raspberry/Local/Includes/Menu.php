<div class="Menu">
	<a href="index.php" class="Lien" id="Lien1">Acceuil</a> |
	<a href="Tuto.php" class="Lien" id="Lien2">Démonstration</a> | 
	<a href="Contact.php" class="Lien" id="Lien1">Contact</a> | 
	
	<?php if(empty($_SESSION['Site'])) //Si le mec est connecté alors j'affiche l'option connexion
		{
			echo '<a href="Connexion.php" class="Lien" id="Lien3">Connexion</a>';
		}
		else // Sinon j'affiche l'option deconnexion
		{
			echo '<a href="Deconnexion.php" class="Lien" id="Lien3">Déconnexion</a>';
		}
	?>
</div>