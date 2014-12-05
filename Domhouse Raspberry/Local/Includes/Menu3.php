<?php	
	if(isset($_SESSION['login']))
	{
		//$link = ConnectBDD(1); //connexion a la BDD du Raspberry <-- Peu crée des ralentissements !
		echo '
			<div class="Menu3">
			<div class="MenuEtat">
				<div class="TitreMenu3"> Les états </div><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Objets Contrôlables</a> <hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les entrées libres</a><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les objets allumés</a> 
			</div>
			<div class="MenuPiece">
				<div class="TitreMenu3"> Les états </div><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Objets Contrôlables</a> <hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les entrées libres</a><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les objets allumés</a> 
			</div>
			</div>';
	}
?>