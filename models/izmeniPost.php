<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id = $_POST['id_post'];
    $naslov = $_POST['naslov'];
    $kat_id = $_POST['cat_id'];
    $tekst = strip_tags($_POST['tekst']);
    $err = 0;
    if(isset($naslov) && isset($id)){
        ucfirst($naslov);
        if(strlen($naslov) < 20 && strlen($naslov) > 100){
            $odgovor = ['msg' => 'Headline must contain min 20 characters and max 100 characters.'];
            echo json_encode($odgovor);
            http_response_code(500);
            $err++;
        }
    }else{
        $err++;
    }
    if(isset($tekst)){
        if(strlen($tekst) < 20){
            $odgovor = ['msg' => 'Text content must contain at least 20 characters.'];
            echo json_encode($odgovor);
            http_response_code(500);
            $err++;
        }
    }else{
        $err++;
    }
    if(!$err){
        $izmeni = updatePost($naslov, $kat_id, $tekst, $id);
        if($izmeni){
            $odgovor = ['msg' => 'You have successfully updated a post.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
        else{
            $odgovor = ['msg' => 'Please try again.'];
            echo json_encode($odgovor);
            http_response_code(500);
        }
    }


}
else{
    header("Location: ../error404.php");
}

