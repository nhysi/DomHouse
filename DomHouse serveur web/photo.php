<?php 
session_start(); 
include("entete.inc.php");

  if(isset($_GET['log']) && !empty($_GET['log'])){ 

?>

<div class="container">

      <div class="row">
	 
	  <div class="col-md-12 "> <div class="well">
	   
<body>
  <div id="contenu">
 <form action="photo.php?log=<?php echo $_GET['log'];?>&photo=<?php echo $_GET['log'].'1'; ?>" enctype="multipart/form-data" method="post">
  Photo 1:  <input name="fichier" size="30" type="file" />
   <input name="upload" type="submit" value="Uploader" />
</form>   

<br>

<form action="photo.php?log=<?php echo $_GET['log'];?>&photo=<?php echo $_GET['log'].'2'; ?>" enctype="multipart/form-data" method="post">
  Photo 2:  <input name="fichier" size="30" type="file" />
   <input name="upload" type="submit" value="Uploader" />
</form>   

<br>

<form action="photo.php?log=<?php echo $_GET['log'];?>&photo=<?php echo $_GET['log'].'3'; ?>" enctype="multipart/form-data" method="post">
  Photo 3:  <input name="fichier" size="30" type="file" />
   <input name="upload" type="submit" value="Uploader" />
</form>   
   
   <br>
   <a href="mainboard.php"> Retour à ma page personnelle </a>
  </div>


<?php

	
if( isset($_POST['upload']) ) { // si formulaire soumis
  if(isset($_GET['photo']) && !empty($_GET['photo'])){
 

   
   $imgLarge=1500;
   $imgHaut=500;
   $imgMax=100000;

	$content_dir = "img/"; // dossier où sera déplacé le fichier
     $extension = "jpg";
	$tmp_file = $_FILES['fichier']['tmp_name'];
        

	if( !is_uploaded_file($tmp_file) )
	{
		exit("Le fichier est introuvable");
	}else{

       $name = $_FILES['fichier']['name'];
        $nom = $_GET['photo'];
       //$dn= tbUsers($_SESSION['logForum']); 


// on vérifie maintenant l'extension
	$type_file = $_FILES['fichier']['type'];
	if( !stristr($type_file, 'jpg') && !stristr($type_file, 'jpeg') && !stristr($type_file, 'png')   )
	{
		exit("Le fichier n'est pas une image jpg ou jpeg ou png");
	}else{
      
  
	if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name) )
	{
		exit("Nom de fichier non valide");
	}else{

	  $donnees=getimagesize($tmp_file);

if (stristr($type_file, 'png')) {    
      $image = imagecreatefrompng($tmp_file);
}else{$image = imagecreatefromjpeg($tmp_file); }
	
	$image_mini = imagecreatetruecolor($imgLarge, $imgHaut); //création image finale
	imagecopyresampled($image_mini, $image, 0, 0, 0, 0, $imgLarge, $imgHaut, $donnees[0], $donnees[1]);//copie avec redimensionnement

        if (stristr($type_file, 'png')) { 
	  imagepng ($image_mini, $content_dir.$name);
        }else{imagejpeg ($image_mini, $content_dir.$name);}
          
        $taille = filesize($content_dir.$name) ; 
 
       if($taille <$imgMax){ 

        //$name_file = $dn['id'].".".$extension;
		$name_file = $nom.".".$extension;
		
        rename($content_dir.$name, $content_dir.$name_file);
     
       /* $req=mysql_query("UPDATE users SET avatare=1  WHERE login='" . $_SESSION['logForum'] . "'");
        if ($req){ 
          echo "<br>image changée";
          header('Refresh:2; url=profil.php');  
        } else{echo'erreur req';} */
		
		echo '<p> image ajouté </p>';
		
      }else{ echo'image trop grande'; unlink($content_dir.$name); }
 
       }
     }  
   }        
  }       
 }
}else{ echo'session non ouvert'; header('Refresh:3; url=index.php'); } 

include("pied.inc.php");


?>