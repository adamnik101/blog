<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == 'POST'){
    include_once '../config/connection.php';
    include_once 'functions.php';
    $survey = $_POST['id_survey'];
    $aktiviraj = aktivirajAnketu($survey);
    if($aktiviraj){
        $odgovor = ['msg'=>'You have successfully activated a survey!'];
        http_response_code(200);
        echo json_encode($odgovor);
    }
    else{
        $odgovor = ['msg'=>'Oops, looks like there was an error!'];
        http_response_code(500);
        echo json_encode($odgovor);
    }
}
else{
    header('Location: ../error404.php');
}