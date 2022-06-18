<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    $id_post = $_POST['user_id'];

    $delete = deleteUser($id_post);
    if($delete->rowCount() == 1){
        $odgovor = ['msg' => 'You have successfully deleted a user'];
        echo json_encode($odgovor);
        http_response_code(200);
    }
    else{
        $odgovor = ['msg' => 'I could not proccess your request.'];
        echo json_encode($odgovor);
        http_response_code(500);
    }
}
else{
    header("Location: ../error404.php");
}
?>
