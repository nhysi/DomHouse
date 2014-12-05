<?php
require_once('AppFunction.php');
/**
 * Répond aux POST par un fichier JSON :)
**/



if (isset($_POST['tag']) && $_POST['tag'] != '') {

    //require_once 'DB_Functions.php';
    //$db = new DB_Functions();
    $tag = $_POST['tag'];

    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    if ($tag == 'login') {

            $response["success"] = loginPwdCorrect($_POST['name'], $_POST['password']);

        echo json_encode($response);


    } else if ($tag =='getDevice'){
      //$room = array();
      dbConnect();
      $sql = 'SELECT label,Pins,NumeroRadio FROM equipement WHERE piece = "'.$_POST['room'].'" ORDER by Pins';
      $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
      while ($data = mysql_fetch_array($req)) {
        if($date['NumeroRadio'=="Relay"]){$state = getPinState($data['Pins']);}else{$state=false;}
        $state = getPinState($data['Pins']);
        $room[] = array("name"=>$data['label'],"value"=>$state, "pin"=>$data['Pins'],'editable'=>true);
        
      }
      dbDisconnect();
      echo json_encode(array("room"=>$room));

       /* if($_POST['room'] == 'Salon'){

            $room = array

            (

              array("name"=>"Lampe","value"=>true, "pin"=>'12','editable'=>true),

              array("name"=>"Télévision","value"=>false,"pin"=>'18','editable'=>true),

              array("name"=>"Ventilateur","value"=>true,"pin"=>'18','editable'=>false),

              array("name"=>"Radiateur","value=">false,"pin"=>'22','editable'=>false)

              );

            echo json_encode(array("room"=>$room));

            // E/JSON(5264): {"Salon":[{"name":"Lampe","value":true,"pin":1},{"name":"T\u00e9l\u00e9vision","value":false,"pin":3},{"name":"Ventilateur","value":true,"pin":4},{"name":"Radiateur","0":true,"pin":5}]}
        }*/

    } else if($tag=='getRoom'){
        $room = array
            (

              array("name"=>"Salon"),
              array("name"=>"Salle à manger"),
              array("name"=>"Salle de bain"),
              array("name"=>"Chambre"),
              array("name"=>"Toilettes"),
              array("name"=>"Garage")

              );

            echo json_encode(array("room"=>$room));
    } else if($tag =='setDevice') {
        $response["success"] = 1;
        updateStatut($_POST['pin'],$_POST['value']);
        $response["newState"] = $_POST['value'];
        echo json_encode($response);

    } else {

        echo "Erreur";

    }

}



?>