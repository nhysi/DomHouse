<?php
 session_start();
 include("entete.inc.php");

?>

  	
	<!--Carousel Header -->
    <header id="myCarousel" class="carousel slide">
	
        <!-- Indicateurs -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('img/dom.jpg');"></div>
                
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('img/dom1.jpg');"></div>
                
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('img/dom5.jpg');"></div>
                
            </div>
			
			<div class="item">
                <div class="fill" style="background-image:url('img/dom3.jpg');"></div>
                
            </div>
			
			
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
    </header>


	 <!-- Page Content -->
    <div class="container">

	  <div id="services" class="col-md-6"> <div class="well">
	   <h3> Services </h3> 
		<p> DomHouse est un service qui permet aux familles de gérer leur installation à distance. 
			Il permet de centraliser le contrôle des différents systèmes de la maison, tels que les portes, les lampes, les volets, le chauffage, etc pour un meilleur confort et plus de sécurité. 
			Nous disposons également d'une application mobile pour la gestion de vos équipements partout et quand vous voulez.

			
		</p>
		
	 </div> </div>
	 
	
	   <div class="col-md-6"> <div class="well">
		 <h3> A propos </h3> 
		<p> Nous sommes une jeune équipe de six étudiants en informatique. <br>
		    Pour plus d'informations <a href="contact.php"> contactez nous </a>. 
			<br> <br> <br><br>
		</p>
		</div> </div>
		
	</div> <!--row-->
	
	
</div> <!--conteneur-->

<?php

//pied
include("pied.inc.php");
?>