<?php	
	if(isset($_SESSION['login']))
	{
		//$link = ConnectBDD(1); //connexion a la BDD du Raspberry <-- Peu cr�e des ralentissements !
		echo '
			<div class="Menu3">
			<div class="MenuEtat">
				<div class="TitreMenu3"> Les �tats </div><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Objets Contr�lables</a> <hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les entr�es libres</a><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les objets allum�s</a> 
			</div>
			<div class="MenuPiece">
				<div class="TitreMenu3"> Les �tats </div><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Objets Contr�lables</a> <hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les entr�es libres</a><hr>
				<a href="MainBoard.php?Filtre=0" class="Lien2" id="Lien6">Les objets allum�s</a> 
			</div>
			</div>';
	}
?>