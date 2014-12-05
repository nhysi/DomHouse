<?php
require_once('Fonctions.php');
$link = ConnectBDD(0);
if(!$link){echo'problme :( '; };

if(isset($_GET['Filtre'])) //Si la personne a cliquer sur un lien alors on ouvre l'iframe avec les données
{
	$Filtre = Secure($link,$_GET['Filtre']); // Echappement de la variable
	if(Ip()) { //Si c'est une Ip Externe je donnne le lien externe
	switch($Filtre)
	{
		case 0: //Dans le cas ou c'est 0, on affiche tous les objets contrôlables
			echo '
				<div class="IFrame">
					<IFRAME src="'.$_SESSION['Site'].'?Filtre=0" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		
		case 1: //Dans le cas ou c'est 1, on affiche toutes les entrée libres pouvant être configurée pour contrôler des objets
			echo '
				<div class="IFrame">
					<IFRAME src="'.$_SESSION['Site'].'?Filtre=1" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		case 2: //Dans le cas ou c'est 2, on affiche tous les périphériques qui sont allumés
			echo '
				<div class="IFrame">
					<IFRAME src="'.$_SESSION['Site'].'?Filtre=2" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		default : //Par defaut c'est la page qui permet de voir l'ensemble des données qui est ouverte
			echo '
				<div class="IFrame">
					<IFRAME src="'.$_SESSION['Site'].'?Filtre=3" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
	}
	}
	else //Sinon si c'est une adresse local alors j'affiche l'adresse local du Raspberry
	{
		$Filtre = Secure($link,$_GET['Filtre']); // Echappement de la variable
		switch($Filtre)
		{
		case 0: //Dans le cas ou c'est 0, on affiche tous les objets contrôlables
			echo '
				<div class="IFrame">
					<IFRAME src="http://192.168.1.9:82/Raspberry/index.php?'.$Filtre.'" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		
		case 1: //Dans le cas ou c'est 1, on affiche toutes les entrée libres pouvant être configurée pour contrôler des objets
			echo '
				<div class="IFrame">
					<IFRAME src="http://192.168.1.9:82/Raspberry/index.php?'.$Filtre.'" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		case 2: //Dans le cas ou c'est 2, on affiche tous les périphériques qui sont allumés
			echo '
				<div class="IFrame">
					<IFRAME src="http://192.168.1.9:82/Raspberry/index.php?'.$Filtre.'" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		default : //Par defaut c'est la page qui permet de voir l'ensemble des données qui est ouverte
			echo '
				<div class="IFrame">
					<IFRAME src="http://192.168.1.9:82/Raspberry/index.php?'.$Filtre.'" class="IFrameDesign" width="100%" height="800px" scrolling=auto frameborder=0> </IFRAME>
				</div>
				<br/>';
			break;
		}
	}
}
else // Sinon on affiche le plan de la maison (comportement par defaut quand on arrive sur mainBoard)
{
	echo '	<div class="IFrame">
				<img src="./Images/Plan_Maison.jpg">
			</div>';
}	
Deco($link);
?>