<?php
 session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Administration</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link href="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
    </head>
 
    <body>	  
	  <?php include('entete.inc.php'); 
	  if(isset($_SESSION['login'])){
	  if($_SESSION['profil']== 1){ 
      
	  include('ConnectBDD.php');
	  
      echo '<h2 align="center"> Page d\'administration </h2>';

	 echo '<div class="container2" align="center">
	       <div class="row">
		   <div class="col-md-8 col-md-offset-2">
		   <div class="well well-sm">';
			  echo '<legend class="text-center">Recherche des utilisateurs</legend>
			  
			  <form class="form-horizontal" action="administration.php" method="post">
			  <fieldset>
              <div class="form-group">
              <label class="col-md-4 control-label"> Rechercher sur base d\'un identifiant:</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="searchLog" value='; if(isset($_POST['searchLog'])) echo htmlentities(trim($_POST['searchLog'])); echo'>
			  </div>
			  <div class="col-md-2">
				<button type="submit" name="rechercherLogin" value="Rechercher identifiant(s)" id="bouton-search">Rechercher</button>
              </div>
              </div>   
             </fieldset>
			 </form><br/>';
			 
			 echo '<form class="form-horizontal" action="administration.php" method="post">
			  <fieldset>
              <div class="form-group">
              <label class="col-md-4 control-label"> Rechercher sur base d\'un nom:</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="searchName" value='; if(isset($_POST['searchName'])) echo htmlentities(trim($_POST['searchName'])); echo'>
			  </div>
			  <div class="col-md-2">
				<button type="submit" name="rechercherNom" value="Rechercher identifiant(s)" id="bouton-search">Rechercher</button>
              </div>
              </div>   
             </fieldset>
			 </form><br/>';
		
		echo '<form class="form-horizontal" action="administration.php" method="post">
		      <fieldset>
			  <div class="form-group">
              <label class="col-md-4 control-label"> Rechercher sur base d\'une adresse mail:</label>
              <div class="col-md-3">
               <input type="text" class="form-control" name="searchMail" value='; if(isset($_POST['searchEmail']))  echo htmlentities(trim($_POST['searchEmail'])); echo'> <br /> 
              </div>
			  <div class="col-md-2">
			   <button type="submit" name="rechercherMail" value="Rechercher Mail(s)" id="bouton-search">Rechercher</button>
			  </div>
			  </div>
			  </fieldset>
			 </form ><br/>';	 		 			 
			 // on teste si le visiteur a soumis le formulaire de recherche d'indentifiant
		if (isset($_POST['rechercherLogin']) && $_POST['rechercherLogin'] == 'Rechercher identifiant(s)') {
			if (isset($_POST['searchLog']) && !empty($_POST['searchLog'])){
		
			 $sql1 = 'SELECT COUNT(*) FROM utilisateur WHERE login LIKE "'.mysqli_real_escape_string($link,$_POST['searchLog']).'%"';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
			 $test = mysqli_fetch_array($req1,MYSQLI_NUM);
			 mysqli_free_result($req1);
			 
			 if($test[0] == 0)
			   echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Aucun résultat trouvé! </div> </div> <br/>';
			 
             else{  			 
			 echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-success" align="center">'.$test[0].' resultat(s) trouvé(s) </div> </div><br/>';
			 echo '<br/><br/><br/>';
			 // on recherche 
			 $sql2 = 'SELECT User_ID,login,nom,prenom,email,date_naissance,pays,ville,code_postal,site_internet,date_inscription FROM utilisateur WHERE login LIKE "'.mysqli_real_escape_string($link,$_POST['searchLog']).'%"';
			 $req2 = mysqli_query($link,$sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.mysql_error());
						
			 echo '
		     <table id="tabperm2" border="1" align="center"> <tr>
			 <th>Identifiant</th> <th>Nom</th> <th>Prenom</th> <th>Adresse EMAIL</th> <th> Date de naissance </th> <th>Pays</th> <th>Ville</th> <th>Code Postal</th> <th>Site internet</th>
			 <th> Date d\'inscription </th> <th> Action </th></tr> ';
			 
			 while($row = mysqli_fetch_array($req2,MYSQLI_ASSOC)){
			  echo '<tr><td>'.$row["login"].'</td><td>'.$row["nom"].'</td><td>'.$row["prenom"].'</td><td>'
		            .$row["email"].'</td><td>'.$row["date_naissance"].'</td><td>'.$row["pays"].'</td><td>'.$row["ville"].'</td><td>'.$row["code_postal"].'</td><td>'.$row["site_internet"].'</td><td>'.$row["date_inscription"].'</td>
					 <td><a href="panel_gestion.php?u_id='.$row["User_ID"].'"><img src="img/fleche.png" alt="Aller vers panel de cet utilisateur" title="Voir le panel de cet utilisateur" width="50" height="50"/></a></td></tr>';
			  }			  	 			  
			  echo '</table>';
			  mysqli_free_result($req2); 
			  }
			  }
			  else echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Le champ est vide. </div> </div><br/>';
		}
		// on teste si le visiteur a soumis le formulaire de recherche de nom
		if (isset($_POST['rechercherNom']) && $_POST['rechercherNom'] == 'Rechercher identifiant(s)') {
			if (isset($_POST['searchName']) && !empty($_POST['searchName'])){
		
			 $sql1 = 'SELECT COUNT(*) FROM utilisateur WHERE nom LIKE "'.mysqli_real_escape_string($link,$_POST['searchName']).'%"';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
			 $test = mysqli_fetch_array($req1,MYSQLI_NUM);
			 mysqli_free_result($req1);
			 
			 if($test[0] == 0)
			   echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Aucun résultat trouvé! </div> </div> <br/>';
			 
             else{  			 
			 echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-success" align="center">'.$test[0].' resultat(s) trouvé(s) </div> </div><br/>';
			 echo '<br/><br/><br/>';
			 // on recherche 
			 $sql1 = 'SELECT User_ID,login,nom,prenom,email,date_naissance,pays,ville,code_postal,site_internet,date_inscription FROM utilisateur WHERE nom LIKE "'.mysqli_real_escape_string($link,$_POST['searchName']).'%"';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
						
			 echo '
			 <table id="tabperm2" border="1" align="center"> <tr>
			 <th>Identifiant</th> <th>Nom</th> <th>Prenom</th> <th>Adresse EMAIL</th> <th> Date de naissance </th> <th>Pays</th> <th>Ville</th> <th>Code Postal</th> <th>Site internet</th>
			 <th> Date d\'inscription </th> <th> Action </th></tr> ';
			 
			 while($row = mysqli_fetch_array($req1,MYSQLI_ASSOC)){
			  echo '<tr><td>'.$row["login"].'</td><td>'.$row["nom"].'</td><td>'.$row["prenom"].'</td><td>'
		            .$row["email"].'</td><td>'.$row["date_naissance"].'</td><td>'.$row["pays"].'</td><td>'.$row["ville"].'</td><td>'.$row["code_postal"].'</td><td>'.$row["site_internet"].'</td><td>'.$row["date_inscription"].'</td>
					 <td><a href="panel_gestion.php?u_id='.$row["User_ID"].'"> <img src="img/fleche.png" alt="Aller vers panel de cet utilisateur" title="Voir le panel de cet utilisateur" width="50" height="50"/> </a></td></tr>';
			  }			  	 			  
			  echo '</table>';
			  mysqli_free_result($req1); 
			  }
			  }
			  else echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Le champ est vide. </div> </div><br/>';
		}
		
		 // on teste si le visiteur a soumis le formulaire de recherche de mail
		if (isset($_POST['rechercherMail']) && $_POST['rechercherMail'] == 'Rechercher Mail(s)') {
			if (isset($_POST['searchMail']) && !empty($_POST['searchMail'])){
		
			 $sql1 = 'SELECT COUNT(*) FROM utilisateur WHERE email LIKE "'.mysqli_real_escape_string($link,$_POST['searchMail']).'%"';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
			 $test = mysqli_fetch_array($req1,MYSQL_NUM);
			 mysqli_free_result($req1);
			 
			 if($test[0] == 0)
			   echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Aucun résultat trouvé! </div> </div> <br/>';
			 
             else{  			 
			 echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-success" align="center">'.$test[0].' resultat(s) trouvé(s) </div> </div> <br/>';
			 echo '<br/><br/><br/>';
			 
			 
			 // on recherche 
			 $sql1 = 'SELECT User_ID,login,nom,prenom,email,date_naissance,pays,ville,code_postal,site_internet,date_inscription FROM utilisateur WHERE email LIKE "'.mysqli_real_escape_string($link,$_POST['searchMail']).'%"';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
			 
			 echo '
			 <table id="tabperm2" border="1" align="center"> <tr>
			 <th>Identifiant</th> <th>Nom</th> <th>Prenom</th> <th>Adresse EMAIL</th> <th> Date de naissance </th> <th>Pays</th> <th>Ville</th> <th>Code Postal</th> <th>Site internet</th>
			 <th> Date d\'inscription </th> <th> Action </th></tr> ';
			 
			 while($row = mysqli_fetch_array($req1,MYSQLI_ASSOC)){
			  echo '<tr><td>'.$row["login"].'</td><td>'.$row["nom"].'</td><td>'.$row["prenom"].'</td><td>'
		            .$row["email"].'</td><td>'.$row["date_naissance"].'</td><td>'.$row["pays"].'</td><td>'.$row["ville"].'</td><td>'.$row["code_postal"].'</td><td>'.$row["site_internet"].'</td><td>'.$row["date_inscription"].'</td>
					 <td><a href="panel_gestion.php?u_id='.$row["User_ID"].'"> <img src="img/fleche.png" alt="Aller vers panel de cet utilisateur" title="Voir le panel de cet utilisateur" width="50" height="50"/> </a></td></tr>';
			  }			  	 			  
			  echo '</table>';
			  mysqli_free_result($req1); 
			  }
			  }
			  else echo '<div class="col-md-4 col-md-offset-4"> <div class="alert alert-danger" align="center"> Le champ est vide. </div> </div> <br/>';
		}
        echo '<br/><hr>';
		echo '<legend class="text-center">Liste complète des utilisateurs</legend>';
			 
		
		
	echo ' 
			 <table id="tabperm2" border="1" align="center"> <tr>
			 <th>Identifiant</th> <th>Nom</th> <th>Prenom</th> <th>Adresse EMAIL</th> <th> Date de naissance </th> <th>Pays</th> <th>Ville</th> <th>Code Postal</th> <th>Site internet</th>
			 <th> Date d\'inscription </th> <th> Action </th></tr> ';
		
		$req = mysqli_query($link,"SELECT User_ID,login,nom,prenom,email,date_naissance,pays,ville,code_postal,site_internet,date_inscription
							FROM utilisateur") or die("erreur sql".mysql_error());
		
		while($row = mysqli_fetch_array($req,MYSQLI_ASSOC)){
		 echo ' <tr><td>'.$row["login"].'</td><td>'.$row["nom"].'</td><td>'.$row["prenom"].'</td><td>'
		            .$row["email"].'</td><td>'.$row["date_naissance"].'</td><td>'.$row["pays"].'</td><td>'.$row["ville"].'</td><td>'.$row["code_postal"].'</td><td>'.$row["site_internet"].'</td><td>'.$row["date_inscription"].'</td>
					 <td><a href="panel_gestion.php?u_id='.$row["User_ID"].'"> <img src="img/fleche.png" alt="Aller vers panel de cet utilisateur" title="Voir le panel de cet utilisateur" width="50" height="50"/> </a></td></tr> ';
        }
	            echo'</table><br/>';
				mysqli_free_result($req);
				mysqli_close($link);
				
				
		  
	 echo '</div></div></div></div>'; 
	  }
	   else
	    echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas administrateur. </div>
			   </div> <br/> <br/> <br/>';
	  }
	   else
	     echo ' <div class="col-md-4 col-md-offset-4">
		        <div class="alert alert-danger" role="alert" align="center"> Accès refusé, vous n\'êtes pas connecté. </div>
			   </div> <br/> <br/> <br/>';
			   
	  include('pied.inc.php'); ?>
	 
	</body>  
</html>