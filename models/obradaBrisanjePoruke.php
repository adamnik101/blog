<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_mess = $_POST['id_mess'];
    if(isset($id_mess)){
        $message = deleteMessage($id_mess);
        if($message == 1){
            $odgovor = ['msg' => 'You have successfully deleted a message.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with getting deleting a message'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}