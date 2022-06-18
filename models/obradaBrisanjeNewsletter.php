<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_news = $_POST['id_news'];
    if(isset($id_news)){
        $news = deleteNewsletter($id_news);
        if($news == 1){
            $odgovor = ['msg' => 'You have successfully deleted a subscribed email.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with deleting newsletter data'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}