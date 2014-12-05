<?php session_start(); 
      include('entete.inc.php');
	  
	  
	if(isset($_SESSION['login']) && isset($_SESSION['profil'])) // On verifie que l'utilisateur s'est bien connecté et que la variable profil n'est pas vide
	{
		if($_SESSION['profil']== 2 || $_SESSION['profil']== 3) //Une fois verifié que la variable n'est pas vide, on peut verifier la valeur quelle contient. 
		{
			if(!empty($_SESSION['Site'])) //On verifie que l'utilisateur a bien un site internet(serveur sur le Raspberry) avant d'afficher le panel.
			{
			include('ConnectBDD.php');
			$sql = 'SELECT User_ID, mdp FROM utilisateur WHERE login = "'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
			        $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$row = mysqli_fetch_array($req,MYSQLI_ASSOC);
					mysqli_free_result($req);
			echo '   <br/>
					 <div class="control_window">
						<IFRAME src="'.$_SESSION['Site'].'/index.php?u_id='.urlencode($row['User_ID']).'" class="radius" width=100% height=700 scrolling=auto frameborder=0> </IFRAME>
					 </div>
					<br/><br/></div>';
					mysqli_close($link);
			}
			else
				 echo '<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger" role="alert" align="center"> Vous n\'avez pas de Raspberry connecté pour le moment. </div>
					</div> <br/> <br/> <br/> <br/>';
		}
		
		if($_SESSION['profil']== 1){ //Accès administrateur panel de gestion
					$id = $_GET['u_id'];
					if (is_numeric($id)){
					include('ConnectBDD.php');
					$sql = 'SELECT site_internet FROM utilisateur WHERE User_ID = "'.mysqli_real_escape_string($link,$id).'%"';
			        $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$row = mysqli_fetch_array($req,MYSQLI_ASSOC);
		            mysqli_free_result($req);
					if(!empty($row["site_internet"])){
						echo '
							   <div class="row">
								<div class="col-md-8 col-md-offset-2"> 
								<div class="well well-sm">
								<legend align="center">  
								 <h3>Panel de gestion utilisateur</h3>
								</legend>
								<br/>
								<div class="control_window">
									<IFRAME src="'.$row["site_internet"].'" class="fenetrePanel" width=100% height=700 scrolling=auto frameborder=0> </IFRAME>
								</div>
							   <br/><br/></div></div></div>';			
					}
					else
						echo '<div class="col-md-4 col-md-offset-4">
							  <div class="alert alert-danger" role="alert" align="center"> Cet utilisateur n\'a pas de Raspberry connecté pour le moment. </div>
							  </div> <br/> <br/> <br/> <br/>';
							  mysqli_close($link);
			       }	  	 			  					
					else
					echo '<div class="col-md-4 col-md-offset-4">
					      <div class="alert alert-danger" role="alert" align="center"> Tentative d\'injection SQL détecté. Bien essayé! :) </div>
						  </div> <br/> <br/> <br/> <br/>';
		}
	
	}
	else 
	 echo '<div class="col-md-4 col-md-offset-4">
		    <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
		   </div> <br/> <br/> <br/><br/>';
		   

   
	
	include('pied.inc.php'); 
	?>
	 