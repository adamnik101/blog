<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['korisnik']->id_uloga == 1){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_kom = $_POST['id_kom'];
    if(isset($id_kom)){
        $kom = deleteComment($id_kom);
        if(isset($kom)){
            $odgovor = ['msg' => 'You have successfully deleted a comment.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with getting post data'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}