<?php
/**
 * Répond aux POST par un fichier JSON :)
**/
require_once('configuration.php');

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    //require_once 'DB_Functions.php';
    //$db = new DB_Functions();

    $tag = $_POST['tag'];


    $response = array("tag" => $tag, "success" => 0, "error" => 0);


    if ($tag == 'login') {

        if($_POST['name']=="test" and $_POST['password']=="test"){
            $response["success"] = true;
        }else{
            $response["success"] = false;
        }
        echo json_encode($response);
        /*
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // Utilisateur trouvé, on construit la réponse.
            $response["success"] = 1;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            // Prendre liste matériel dont on possède les droits
            echo json_encode($response);
        } else {
            // Pas trouvé, réponse erreur.
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }*/


    } else if ($tag =='getDevice'){

        if($_POST['room'] == 'Chambre'){
            $room = array
            (
              array("name"=>"Amplificateur","value"=>true, "pin"=>11),
              array("name"=>"Lampe","value"=>false,"pin"=>12),
              array("name"=>"Ventilateur","value"=>true,"pin"=>16),
              );
            echo json_encode(array("room"=>$room));
            // E/JSON(5264): {"Salon":[{"name":"Lampe","value":true,"pin":1},{"name":"T\u00e9l\u00e9vision","value":false,"pin":3},{"name":"Ventilateur","value":true,"pin":4},{"name":"Radiateur","0":true,"pin":5}]}
        }else{
            $room = array
            (
              array("name"=>"Lampe","value"=>true, "pin"=>1),
              array("name"=>"Radiateur","value"=>true,"pin"=>4),
              );
            echo json_encode(array("room"=>$room));
        }
    } else if($tag =='setDevice') {

        system("gpio write ".$pins[$_POST['pin']]." ".$_POST['value']);
    } else {
        echo "Erreur";
    }
}

?>


