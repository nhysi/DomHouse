<?php session_start(); 
      include('entete.inc.php');
	  
	  if(isset($_SESSION['login'])){
	  
	  include("ConnectBDD.php");
?>

    <div class="container">

      <div class="row">
	 
	  <div class="col-md-8 col-md-offset-2 "> 
	    <div class="well">
		<?php if($_SESSION['profil'] == 2){
		
		echo '<h2 align="center"> Voir ou modifier les permissions de vos sous-utilisateurs </h2>';
		echo '<h3> Liste des sous-utilisateurs </h3>';
		$sql = 'SELECT COUNT(*) FROM utilisateur WHERE site_internet = "'.mysqli_real_escape_string($link,$_SESSION['Site']).'" AND date_naissance IS NULL';
		$req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$data = mysqli_fetch_array($req,MYSQLI_NUM);
		if($data[0] != 0){
		$sql1 = 'SELECT User_ID,login,nom,prenom,date_inscription FROM utilisateur WHERE site_internet = "'.mysqli_real_escape_string($link,$_SESSION['Site']).'" AND date_naissance IS NULL';
			 $req1 = mysqli_query($link,$sql1) or die('Erreur SQL !<br />'.$sql1.'<br />'.mysql_error());
			
			echo '			
             <div class="table-responsive"> 
	         <table class="table table-condensed table-bordered table-stripped"><thead> <tr>
			 <th>Identifiant</th> <th>Nom</th> <th>Prenom</th><th> Date d\'inscription </th> <th> Action </th></tr></thead> ';
			 
			 while($row = mysqli_fetch_array($req1,MYSQLI_ASSOC)){
			  echo '<tbody><tr><td>'.$row["login"].'</td><td>'.$row["nom"].'</td><td>'.$row["prenom"].'</td><td>'.$row["date_inscription"].'</td>
					 <td><a href="EtatPermissions.php?id='.$row["User_ID"].'"><img src="img/fleche2.png" alt="Voir ou modifier les permissions de cet utilisateur" title="Voir ou modifier les permissions de cet utilisateur" width="50" height="50"/></a></td></tr></tbody>';
			  }			  	 			  
			  echo '</table>';
			  mysqli_free_result($req1); 
			  }
			  else
			   echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Aucun résultat!</div></div>';
			 
			  mysqli_free_result($req);
			  
			  if(isset($_GET['id'])){
			  if(is_numeric($_GET['id'])){
			  include('ConnectBDDRaspberry.php');
			  //ce user id existe t-il?
			  $sql2 = 'SELECT COUNT(*), login FROM utilisateur WHERE User_ID = "'.mysqli_real_escape_string($link,$_GET['id']).'" AND date_naissance IS NULL';
			  $req2 = mysqli_query($link,$sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.mysql_error());
			  $row2 = mysqli_fetch_array($req2,MYSQLI_NUM);
			  //si oui alors on verifie si ce user à des permissions individuelles ou de groupes
			  echo '<h3>Permissions de '.$row2[1].'</h3><br/>';
			  if($row2[0] == 1){
			  $sqlPerm = 'SELECT COUNT(*) FROM user_eq WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$_GET['id']).'"';
			  $reqPerm = mysqli_query($linkRaspberry,$sqlPerm) or die('Erreur SQL !<br />'.$sqlPerm.'<br />'.mysql_error());
			  $rowPerm = mysqli_fetch_array($reqPerm,MYSQLI_NUM);
			  if($rowPerm[0] != 0){
			   //permissions individuelles
			   echo '<h4>Type de permissions: Individuelles</h4>';
			   $sql3 = 'SELECT idEquip, acces FROM user_eq WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$_GET['id']).'"';
			   $req3 = mysqli_query($linkRaspberry,$sql3) or die('Erreur SQL !<br />'.$sql3.'<br />'.mysql_error());
			   echo '<div class="table-responsive"> 
	            <table class="table table-condensed table-bordered table-stripped"><thead> <tr>
			    <th>Equipement accessible</th><th>Catégorie</th><th>Pièce</th><th>Droit sur l\'équipement</th></tr></thead> ';
			   while($row3 = mysqli_fetch_array($req3,MYSQLI_NUM)){
			    $sql4 = 'SELECT label, categorie, piece FROM equipement WHERE idEquip = "'.mysqli_real_escape_string($linkRaspberry,$row3[0]).'"';
			    $req4 = mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !<br />'.$sql4.'<br />'.mysql_error());
				$row4 = mysqli_fetch_array($req4,MYSQLI_NUM);
				echo '<tbody><tr><td>'.$row4[0].'</td><td>'.$row4[1].'</td><td>'.$row4[2].'</td><td>'; if($row3[1]== 1) echo 'Modification'; else echo 'Lecture'; echo '</td></tr></tbody>';
			   	}				
			    echo '</table><br/>';
			   mysqli_free_result($req3);
			   mysqli_free_result($req4);
			   echo '<p align="center"><a href="modifPermUser.php?u_id='.$_GET['id'].'">Modifier les permissions de cet utilisateur</a></p>';
			   }
			   else{
			   //permissions de groupe
			   echo '<h4>Type de permissions: Groupe</h4>';
			   //recupération de l'id groupe
			   $sqlGrp = 'SELECT idGrp FROM userGrp WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$_GET['id']).'"';
			   $reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			   $rowGrp = mysqli_fetch_array($reqGrp,MYSQLI_NUM);
			   mysqli_free_result($reqGrp);
			  
			   $sqlGrpBis = 'SELECT label, description FROM groupe WHERE idgroupe = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp[0]).'"';
			   $reqGrpBis = mysqli_query($linkRaspberry,$sqlGrpBis) or die('Erreur SQL !<br />'.$sqlGrpBis.'<br />'.mysql_error());
			   $rowGrpBis = mysqli_fetch_array($reqGrpBis,MYSQLI_NUM);
			   mysqli_free_result($reqGrpBis);
   			   
			   echo '<h5>Nom du groupe: '.$rowGrpBis[0].'</h5>';
			   echo '<h5>Description du groupe: '.$rowGrpBis[1].'</h5><br/>';
			   
			   $sqlGrp2 = 'SELECT idEquip, acces FROM eq_grp WHERE idGrp = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp[0]).'"';
			   $reqGrp2 = mysqli_query($linkRaspberry,$sqlGrp2) or die('Erreur SQL !<br />'.$sqlGrp2.'<br />'.mysql_error());
			   echo '<div class="table-responsive"> 
	            <table class="table table-condensed table-bordered table-stripped"><thead> <tr>
			    <th>Equipement accessible</th><th>Catégorie</th><th>Pièce</th><th>Droit sur l\'équipement</th></tr></thead> ';
			   while($rowGrp2 = mysqli_fetch_array($reqGrp2,MYSQLI_NUM)){
			    $sql4 = 'SELECT label, categorie, piece FROM equipement WHERE idEquip = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp2[0]).'"';
			    $req4 = mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !<br />'.$sql4.'<br />'.mysql_error());
				$row4 = mysqli_fetch_array($req4,MYSQLI_NUM);
				echo '<tbody><tr><td>'.$row4[0].'</td><td>'.$row4[1].'</td><td>'.$row4[2].'</td><td>'; if($rowGrp2[1]== 1) echo 'Modification'; else echo 'Lecture'; echo '</td></tr></tbody>';   
			   }
			   echo '</table><br/>';
			   mysqli_free_result($reqGrp2);
			   mysqli_free_result($req4);
			   echo '<p align="center"><a href="modifPermGrp.php?id_grp='.$rowGrp[0].'">Modifier les permissions de ce groupe</a></p>';
			   }
			  }
			  else //si non
			  echo '<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger" role="alert" align="center"> Id d\'utilisateur inconnu. </div>
				    </div> <br/> <br/> <br/> <br/>';
					
			  mysqli_free_result($req2);
			  mysqli_close($linkRaspberry);
			  }
			   else
				echo '<div class="col-md-4 col-md-offset-4">
					      <div class="alert alert-danger" role="alert" align="center"> Tentative d\'injection SQL détecté. Bien essayé! :) </div>
						  </div> <br/> <br/> <br/> <br/>';
			  }
			mysqli_close($link);
		}

	    if($_SESSION['profil'] == 3){
	
		echo '<h2 align="center"> Voir vos permissions </h2>';
		include('ConnectBDDRaspberry.php');
			  //recupération du user_id du sous-user
			  $sql2 = 'SELECT User_ID FROM utilisateur WHERE login = "'.mysqli_real_escape_string($link,$_SESSION['login']).'"';
			  $req2 = mysqli_query($link,$sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.mysql_error());
			  $row2 = mysqli_fetch_array($req2,MYSQLI_NUM);
			  
			  //on vérifie quelles types de permissions à l'utilisateur
			  $sqlPerm = 'SELECT COUNT(*) FROM user_eq WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$row2[0]).'"';
			  $reqPerm = mysqli_query($linkRaspberry,$sqlPerm) or die('Erreur SQL !<br />'.$sqlPerm.'<br />'.mysql_error());
			  $rowPerm = mysqli_fetch_array($reqPerm,MYSQLI_NUM);
			  if($rowPerm[0] != 0){
			   //permissions individuelles
			   echo '<h4>Type de permissions: Individuelles</h4>';
			   $sql3 = 'SELECT idEquip, acces FROM user_eq WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$row2[0]).'"';
			   $req3 = mysqli_query($linkRaspberry,$sql3) or die('Erreur SQL !<br />'.$sql3.'<br />'.mysql_error());
			   echo '<div class="table-responsive"> 
	            <table class="table table-condensed table-bordered table-stripped"><thead> <tr>
			    <th>Equipement accessible</th><th>Catégorie</th><th>Pièce</th><th>Droit sur l\'équipement</th></tr></thead> ';
			   while($row3 = mysqli_fetch_array($req3,MYSQLI_NUM)){
			    $sql4 = 'SELECT label, categorie, piece FROM equipement WHERE idEquip = "'.mysqli_real_escape_string($linkRaspberry,$row3[0]).'"';
			    $req4 = mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !<br />'.$sql4.'<br />'.mysql_error());
				$row4 = mysqli_fetch_array($req4,MYSQLI_NUM);
				echo '<tbody><tr><td>'.$row4[0].'</td><td>'.$row4[1].'</td><td>'.$row4[2].'</td><td>'; if($row3[1]== 1) echo 'Modification'; else echo 'Lecture'; echo '</td></tr></tbody>';
			   	}				
			    echo '</table><br/>';
			   mysqli_free_result($req3);
			   mysqli_free_result($req4);
			   }
			   else{
			   //permissions de groupe
			   echo '<h4>Type de permissions: Groupe</h4>';
			   //recupération de l'id groupe
			   $sqlGrp = 'SELECT idGrp FROM userGrp WHERE idUser = "'.mysqli_real_escape_string($linkRaspberry,$row2[0]).'"';
			   $reqGrp = mysqli_query($linkRaspberry,$sqlGrp) or die('Erreur SQL !<br />'.$sqlGrp.'<br />'.mysql_error());
			   $rowGrp = mysqli_fetch_array($reqGrp,MYSQLI_NUM);
			   mysqli_free_result($reqGrp);
			   
			   $sqlGrpBis = 'SELECT label, description FROM groupe WHERE idgroupe = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp[0]).'"';
			   $reqGrpBis = mysqli_query($linkRaspberry,$sqlGrpBis) or die('Erreur SQL !<br />'.$sqlGrpBis.'<br />'.mysql_error());
			   $rowGrpBis = mysqli_fetch_array($reqGrpBis,MYSQLI_NUM);
			   mysqli_free_result($reqGrpBis);
   			   
			   echo '<h5>Nom du groupe: '.$rowGrpBis[0].'</h5>';
			   echo '<h5>Description du groupe: '.$rowGrpBis[1].'</h5><br/>';
			   
			   $sqlGrp2 = 'SELECT idEquip, acces FROM eq_grp WHERE idGrp = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp[0]).'"';
			   $reqGrp2 = mysqli_query($linkRaspberry,$sqlGrp2) or die('Erreur SQL !<br />'.$sqlGrp2.'<br />'.mysql_error());
			   echo '<div class="table-responsive"> 
	            <table class="table table-condensed table-bordered table-stripped"><thead> <tr>
			    <th>Equipement accessible</th><th>Catégorie</th><th>Pièce</th><th>Droit sur l\'équipement</th></tr></thead> ';
			   while($rowGrp2 = mysqli_fetch_array($reqGrp2,MYSQLI_NUM)){
			    $sql4 = 'SELECT label, categorie, piece FROM equipement WHERE idEquip = "'.mysqli_real_escape_string($linkRaspberry,$rowGrp2[0]).'"';
			    $req4 = mysqli_query($linkRaspberry,$sql4) or die('Erreur SQL !<br />'.$sql4.'<br />'.mysql_error());
				$row4 = mysqli_fetch_array($req4,MYSQLI_NUM);
				echo '<tbody><tr><td>'.$row4[0].'</td><td>'.$row4[1].'</td><td>'.$row4[2].'</td><td>'; if($rowGrp2[1]== 1) echo 'Modification'; else echo 'Lecture'; echo '</td></tr></tbody>';   
			   }
			   echo '</table><br/>';
			   mysqli_free_result($reqGrp2);
			   mysqli_free_result($req4);
			   }		
			  mysqli_free_result($req2);
			  mysqli_close($linkRaspberry);
	    }
     }
	 echo ' </div> <!--well--> 
		 </div> <!--col-->
	    </div> <!--row-->
	</div> <!--content-->';	 
	 include('pied.inc.php'); 
	?>