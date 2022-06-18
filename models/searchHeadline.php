<?php
session_start();
if(isset($_GET['text'])){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $text = $_GET['text'];
    if(isset($text) && !empty($text)){
        $dohvati = getSearchHeadline($text);
        if($dohvati){
            $odgovor = ['msg' =>$dohvati];
            http_response_code(200);
            echo json_encode($odgovor);
        }
    }
}else{
    header("Location: ../error404.php");
}