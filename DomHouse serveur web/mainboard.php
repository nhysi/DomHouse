<?php session_start(); 
      include('entete.inc.php');
	  include ('ConnectBDDRaspberry.php');
	  //include('config.php');
	 
?>


    <div class="container">

      <div class="row">
	 
	 
	  
	   
	  <?php if(isset($_SESSION['login']) && $_SESSION['profil']== 1 || $_SESSION['profil']== 2){  
	    $req1= mysqli_query ($linkRaspberry,'select distinct piece from equipement') 
		       or die('Erreur SQL !<br /> select piece from equipement <br />'.mysql_error());
		
		echo'<div class="col-md-2"> <br>
                
                <div class="list-group"> 
				   <h4 class="list-group-item"><a href ="mainboard.php"> <b>Pièces </b> </a></h4>';
		
		while ($pieces = mysqli_fetch_array($req1, MYSQLI_ASSOC)) {
		
		echo' <a href="mainboard.php?piece='.$pieces['piece'].'"class="list-group-item">'.$pieces['piece'].'</a>';  //liste des pieces
        }
	  
	  ?>
	        </div>
            </div> <!-- col -->
			
			<div class="col-md-9 "> 
			   <div class="well">

	  <br/> <h2 align="center"> Bienvenue sur votre mainboard! </h2>
	<br>
	 <!--<p align="center"> <img src="img/plan-maison.jpg" alt="plan maison"> </p> -->	
	 <br>
   
       
<?php
if (!empty ($_GET['piece']) ){

	if(!empty($_SESSION['Site'])) //On verifie que l'utilisateur a bien un site internet(serveur sur le Raspberry) avant d'afficher le panel.
			{
			include('ConnectBDD.php');
			$sql = 'SELECT User_ID, mdp FROM utilisateur WHERE login = "'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
			        $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$row = mysqli_fetch_array($req,MYSQLI_ASSOC);
					mysqli_free_result($req);
			echo '   <br/>
					 <div class="control_window">
						<IFRAME src="'.$_SESSION['Site'].'/test.php?u_id='.urlencode($row['User_ID']).'&piece='.urlencode($_GET['piece']).'&login='.urlencode($_SESSION['login']).'&mdp='.urlencode($row['mdp']).'" class="radius" width=100% height=400 scrolling=auto frameborder=0> </IFRAME>
					 </div>
					<br/>';
					mysqli_close($link);
			}
			else
				 echo '<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger" role="alert" align="center"> Vous n\'avez pas de Raspberry connecté pour le moment. </div>
					</div> <br/> <br/> ';





} else {echo '<p align="center"> <img src="img/maison.jpg" width="800" height="600" alt="plan maison" border="0" usemap="#pmaison" /> </p>'; ?>
              <map name="pmaison" id="pmaison">
				<area shape="rect" coords="40,100,200,370" href="mainboard.php?piece=Chambre " alt="Chambre" />
				<area shape="rect" coords="570,90,750,260" href="mainboard.php?piece=cuisine" alt="Cuisine" />
				<area shape="rect" coords="350,370,575,570" href="mainboard.php?piece=Salon" alt="Salon" />
				<area shape="rect" coords="240,370,350,570" href="mainboard.php?piece=Salle de bain" alt="Salle de bain" />
               </map>
            
      <?php  }

//<img src="img/plan-maison.jpg" alt="plan maison"> 


	if($_SESSION['profil'] == 1) 
	 echo '<p align="center"> <a class="btn btn-default" href="inscriptionUser.php">Inscription d\'un utilisateur</a> </p> <br/>';
	
	if($_SESSION['profil'] == 2)
	 echo '<p align="center"> <a class="btn btn-default" href="inscriptionSousUser.php">Inscription d\'un sous utilisateur</a> </p> <br/>';
	 
	if($_SESSION['profil'] == 1 || $_SESSION['profil'] == 2) 
	 echo '<p align="center"> <a class="btn btn-default" href="modifProfil.php">Modifier le profil</a> </p> <br/>';
	}
	else 
	 echo '<div class="col-md-4 col-md-offset-4">
		    <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
		   </div> <br/> <br/> <br/>
		 
	   
	';


/* Fermeture de la connexion */
mysqli_close($linkRaspberry);
?>

	 </div> <!--well-->	
 	
	</div> <!-- col9 --> 
	</div> <!--row-->
</div> <!--content-->	

 <?php 
 mysql_close (); 
 include('pied.inc.php');  ?>