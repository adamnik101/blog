<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    $id_kor = $_SESSION['korisnik']->id_kor;
    $poruka = strip_tags($_POST['message']);
    $post_id = $_POST['id_post'];
    if(isset($id_kor)){
        if(isset($poruka) && isset($post_id)){
            if(strlen($poruka) < 20){
                $odgovor = ['msg' => 'Comment must contain at least 20 characters'];
                echo json_encode($odgovor);
                http_response_code(500);
            }
            else{
                $unos = unesiKomentar($poruka, $post_id, $id_kor);
                if($unos->rowCount() == 1){
                    $odgovor = ['msg' => 'You have successfully sent a comment.'];
                    echo json_encode($odgovor);
                    http_response_code(201);
                }
                else{
                    $odgovor = ['msg' => 'Oops, we could not send a comment'];
                    echo json_encode($odgovor);
                    http_response_code(500);
                }
            }
        }
        else{
            $odgovor = ['msg' => 'Error'];
            echo json_encode($odgovor);
            http_response_code(500);
        }
    }
    else{
        $odgovor = ['msg' =>'Error with fetching user data'];
        echo json_encode($id_kor);
        http_response_code(200);
    }

}
else{
    header("Location: error404.php");
}
