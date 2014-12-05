<?php	
	if(isset($_SESSION['login']))
	{
		echo '
			<div class="Menu2">|
				<a href="MainBoard.php" class="Lien" id="Lien4">MainBoard</a> |
				<a href="Tuto.php" class="Lien" id="Lien5">Profil</a> | 
				<a href="Contact.php" class="Lien" id="Lien4">Permissions</a> | 
			</div>';
	}
?>