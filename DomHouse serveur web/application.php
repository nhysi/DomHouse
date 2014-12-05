<?php

session_start(); 
      include('entete.inc.php');
	  include ('ConnectBDDRaspberry.php');
	  //include('config.php');
?>

  <div class="container">
    <div class="row"> 
     <div class="col-md-9 "> 
	   <div class="well">	
<?php 

  if(isset($_SESSION['login']) && $_SESSION['profil']== 1 || $_SESSION['profil']== 2){  
      echo'Hello, Vous pouver telecharger notre application ICI ';
  }else 
	 echo '<div class="col-md-4 col-md-offset-4">
		    <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
		   </div> <br/> <br/> <br/>';
?>
 	  </div> <!--well-->	
	</div> <!-- col -->
  </div> <!--row-->
</div> <!--content-->	
 <?php 
 include('pied.inc.php');  ?>