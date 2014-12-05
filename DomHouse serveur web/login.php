 <?php
    // on teste si le visiteur a soumis le formulaire de connexion
    if(isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion'){
    if((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['mdp']) && !empty($_POST['mdp']))){
     include("ConnectBDD.php"); //Connection à la BDD
	
	  // définition de la fonction de hachage (Sha512)	 
		//define('FonctionDeHachage', 'sha512');

		// Fonction de hashage
		/*function password_hashage($password, $salt) {
			$hash = hash(FonctionDeHachage, $password+$salt);
			return $hash;
		}*/
	  
      //on récupère le sel
	  $sqlSalt = 'SELECT sel FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_POST['login']).'"';
      $reqSalt = mysqli_query($link,$sqlSalt) or die('Erreur SQL !<br />'.mysql_error());
      $dataSalt = mysqli_fetch_array($reqSalt,MYSQLI_NUM);
	  $salt = $dataSalt[0];
	  mysqli_free_result($reqSalt);
	  
	 // $mdp = password_hashage($_POST['mdp'], $dataSalt[0]);

     // on teste si une entrée de la base contient ce couple login / pass
     $sql = 'SELECT count(*),User_ID FROM utilisateur WHERE login="'.mysqli_real_escape_string($link,$_POST['login']).'" AND mdp="'.mysqli_real_escape_string($link,sha1($_POST['mdp'].$salt)).'"';
     $req = mysqli_query($link,$sql) or die('Erreur SQL !<br />'.mysql_error());
     $data = mysqli_fetch_array($req,MYSQLI_BOTH);

	 // Récupération des variables necessaires à la vérification du champ 'grade_id' de la BDD
	 $id = $data['User_ID'];

	 // Récupération de la valeur du champ actif pour le login $login	
	 $stmt = mysqli_query($link,"SELECT grade_id FROM profil WHERE User_ID = '$id' ")
	 or die("Erreur SQL!".mysql_error());
	 $url = mysqli_query($link,"SELECT site_internet FROM utilisateur WHERE User_ID = '$id' ")
	 or die("Erreur SQL!".mysql_error());
	
	 while($row = mysqli_fetch_array($stmt,MYSQLI_NUM))
     $grade = $row[0]; 
	
	 $site = mysqli_fetch_array($url);
	
     mysqli_free_result($req);
	 mysqli_free_result($stmt);
	 mysqli_free_result($url);

     // si on obtient une réponse, alors l'utilisateur est un membre
     if ($data[0] == 1) {

       session_start();
	   $_SESSION['login'] = $_POST['login'];
       $_SESSION['profil'] = $grade; 
	   if(!empty($site)) $_SESSION['Site'] = $site['site_internet'];
	   if($_SESSION['profil'] == 1)
	    header("Location:administration.php");
	   else
	    header("Location:mainboard.php");

      mysqli_close($link);	 	 
     }
	 // si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
     elseif ($data[0] == 0) $erreur = '<div class="alert alert-danger" role="alert" align="center">Combinaison login/mot de passe incorrecte. Veuillez réessayer.</div>';
     // sinon, alors la, il y a un gros problème :)
     else $erreur = '<div class="alert alert-danger" role="alert" align="center"> Erreur interne. Merci de réessayer plus tard. </div>';
     }
     else $erreur = '<div class="alert alert-danger" role="alert" align="center"> Au moins un des champs est vide. Merci de remplir tout les champs requis. </div>';
    }
    ?>