<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sent'])){
    include_once '../config/connection.php';
    include_once 'functions.php';
    $odgovor_id = $_POST['odgovor'];
    $survey_id = $_POST['sent'];
    $korisnik_id = $_SESSION['korisnik']->id_kor;
    $unesiOdgovor = unesiOdgovor($survey_id, $odgovor_id, $korisnik_id);
    if($unesiOdgovor){
        $loc = explode('/', $_SERVER['HTTP_REFERER'])[4];
        $_SESSION['anketaUspeh'] = 'Thank you for answering our survey!';
        header('Location: ../'.$loc);
        die();
    }
    else{
        $_SESSION['anketaErr'] = 'There was an error with getting your survey data.';
        header('Location: ../'.$loc);
        die();
    }
}
else{
    header('Location: ../error404.php');
}
?>