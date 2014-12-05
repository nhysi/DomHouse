<?php
 session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Inscription d'un sous utilisateur</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap-contact.js" type="text/javascript"></script>

    </head>
    
	<body>
     <?php include("entete.inc.php"); 
	  if(isset($_SESSION['login'])){
	  if($_SESSION['profil']== 2){
		include('ConnectBDDRaspberry.php');	
	 ?>	  
	  
	  <div class="row">
       <div class="col-md-6 col-md-offset-3">
        <div class="well well-sm">
			
			<legend class="text-center">Inscription d'un utilisateur</legend>
            <p align="center"><span class="label label-info">Choisissez le type de permission à définir.</span></p><br/>
			<p align="center"> <a class="btn btn-default" href="PermPerso.php">Créer un utilisateur ayant des permissions individuelles</a></p>
			<br/><br/>
			<p align="center"> <a class="btn btn-default" href="PermGroup.php">Créer un utilisateur ayant des permissions de groupe</a> </p> <br/>
	<?php		
	  }
	   else
	    echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas un utilisateur primaire. </div>
			   </div> <br/> <br/> <br/>';
	  }
	   else
	     echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
			   </div> <br/> <br/> <br/>';
			   
	  include("pied.inc.php"); ?>
    </body>
</html>