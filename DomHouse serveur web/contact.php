<?php
 session_start();
 ini_set("display_errors",0);
 error_reporting(0);
 //entete
 include("entete.inc.php");

 if (isset($_POST['envoi'])){
  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
   //$nom=htmlentities(trim($_POST['nom']));  
   $email=htmlentities(trim($_POST['email']));
   $message=htmlentities(trim($_POST['message'])); 
   $objet=htmlentities(trim($_POST['sujet'])); 
   
   $destinataire = "domhouse@yopmail.com";
   $entete = "MIME-Version: 1.0"."\r\n";
   $entete .= "Content-type: text/html; charset=iso-8859-1"."\r\n";
   $entete .= "From: ".$_SESSION['login']." <".$email.">\r\nReply-to : ".$_SESSION['login']." <".$email.">\nX-Mailer:PHP";
   $subject="$objet";
   $body= "$message"; 
                         
   // Envoi du mail
   if (mail($destinataire,$subject,$body)) { 
      echo 'Votre mail a été envoyé<br>
            <a href="index.php"> <b>Retour à la page d accueil</b> </a></div>'; 
  } else { echo '<div class="col-md-6 col-md-offset-3"><div class="alert alert-success" role="alert" align="center">Email envoyé avec succès!</div></div>'; } 
 }else{
   echo'<div class="col-md-6 col-md-offset-3"><div class="alert alert-danger" role="alert" align="center">Email non valide, reessayez.</div></div><br/>';}
}
?>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="well well-sm">
      <form class="form-horizontal" action="contact.php" method="post">
          <fieldset>
            <legend class="text-center">Nous contacter </legend>
    
            <!-- Sujet-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="nom">Sujet</label>
              <div class="col-md-9">
                <input id="sujet" name="sujet" type="text" placeholder="Votre sujet" class="form-control">
              </div>
            </div>
    
            <!-- Email-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="email">E-mail</label>
              <div class="col-md-9">
                <input id="email" name="email" type="text" placeholder="Votre email" class="form-control">
              </div>
            </div>
    
            <!-- Message -->
            <div class="form-group">
              <label class="col-md-2 control-label" for="message">Message</label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="Ecrivez votre message ici..." rows="5"></textarea>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-11 text-right">
                <button type="submit" name="envoi" class="btn btn-primary btn-lg">Submit</button>
              </div>
            </div>
          </fieldset>
         </form>
        </div>  <!-- well -->
      </div>
	 </div>  <!-- row -->

<?php
//pied
include("pied.inc.php");
?>
