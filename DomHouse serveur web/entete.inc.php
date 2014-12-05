<!DOCTYPE html>
 <html>
  <head>
    <title> DomHouse: Domotique </title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
	<link href="css/csstest.css" rel="stylesheet" type="text/css" />
  </head>
  
  
   <body>

    <div class="container">
	
	<p class="logo">
	 <a href="index.php"><img src="img/DomHouse Logo.png" alt="Logo de DomHouse" width="425" height="130"/></a>
	</p>

<br>
<nav class="navbar navbar-default" role="navigation">
   <div>
      <ul class="nav navbar-nav">
	  
	  <?php   if(isset($_SESSION['login']) && isset($_SESSION['profil'])){  ?>         
         <div class="navbar-header">
		  <li><a href="index.php" class="navbar-brand"><font color="black">&nbsp; <?php echo $_SESSION['login']; ?></font></a></li>
		 </div>         
					<?php
					if($_SESSION['profil'] != 1){ 
					 echo '<li><a href="contact.php"><span class="glyphicon glyphicon-list"></span> &nbsp; Contact</a></li>';
					 echo '<li><a href="mainboard.php"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Page d\'accueil</a></li>';
					 echo '<li><a href="panel_gestion.php"><span class="glyphicon glyphicon-off"></span> Panel de gestion</a></li>';
					 echo '<li><a href="modifProfil.php"><span class="glyphicon glyphicon-user"></span> Modifier Profil</a></li>';
					}
					 if($_SESSION['profil'] == 1){
					  echo '<li><a href="administration.php"><span class="glyphicon glyphicon-tower"></span> Administration</a></li>';
					  echo '<li><a href="inscriptionUser.php"><span class="glyphicon glyphicon-tower"></span> Inscriptions utilisateur</a></li>';
					  }
					 if($_SESSION['profil'] == 2)
					  echo '<li><a href="EtatPermissions.php"><span class="glyphicon glyphicon-tower"></span> Permissions </a></li>';
				    ?>
				 <li><a href="application.php"><span class="glyphicon glyphicon-phone"></span> &nbsp; Application</a></li>
				<li><a href="deconnexion.php"><span class="glyphicon glyphicon-eye-close"></span> &nbsp; Deconnexion</a></li>
				</ul>
			<?php
		  }
		  else{
  
		  echo' 
		   <li><a href="contact.php">Contact</a></li>
           <li><a href="connexion.php">Connexion</a></li> ';	 
		  }	 
         ?>
   </div>
</nav>

</div>
</body>
</html>