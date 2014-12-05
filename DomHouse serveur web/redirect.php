<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dom-House: Redirection</title>
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

	  </ul> 
   </div>
</nav>
	  </div>
        <?php
		if(isset($_GET['msg'])){
		header ("Refresh: 3;URL=mainboard.php");
		echo '<div class="col-md-4 col-md-offset-4"><div class="alert alert-success" role="alert" align="center">'.$_GET['msg'].'</div></div><br/><br/><br/>';
		}
		else
		header ("Refresh: 1;URL=mainboard.php"); ?>

	  <?php include("pied.inc.php"); ?>
    </body>
</html>
