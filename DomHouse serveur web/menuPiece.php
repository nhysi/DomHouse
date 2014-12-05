 
	   
	  <?php 
	  
	  include ('ConnectBDDRaspberry.php');
	  
	  
	    $req1= mysqli_query ($linkRaspberry,'select distinct piece from equipement') 
		       or die('Erreur SQL !<br /> select piece from equipement <br />'.mysql_error());
		
		echo'<div class="col-md-2"> <br>
                
                <div class="list-group"> 
				   <h4 class="list-group-item"><a href ="mainboard.php"> <b>Pièces </b> </a></h4>';
		
		while ($pieces = mysqli_fetch_array($req1, MYSQLI_ASSOC)) {
		
		echo' <a href="mainboard.php?piece='.$pieces['piece'].'"class="list-group-item">'.$pieces['piece'].'</a>';  //liste des pieces
        }
	  
	  ?>
	        </div>
            </div> <!-- col -->