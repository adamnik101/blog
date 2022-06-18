<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSurvey'])){
    include_once '../config/connection.php';
    include_once 'functions.php';
    $survey = $_POST['answer'];
    $pitanje = $_POST['pitanje'];
    $regPitanje = '/[A-ZŠĐČĆŽ][a-zšđčćž]{1,19}(\s[a-zšđčćž]{2,19})*[?]/';
    $reg = '/[A-ZŠĐČĆŽ][a-zšđčćž]{1,19}(\s[a-zšđčćž]{2,19})*/';
    if(is_array($survey)){
        foreach ($survey as $odgovor){
            if(!preg_match($reg, $odgovor)){
                $_SESSION['surrErr'] = 'Answer must contain only letters and must start with a capital letter.';
                header('Location: ../adminPanel.php');
                die();
            }
        }
    }
    if(isset($pitanje)){
        if(!preg_match($regPitanje, $pitanje)){
            $_SESSION['surrErr'] = 'Question must contain only letters, question mark and must start with a capital letter.';
            header("Location: ../adminPanel.php");
            die();
        }
    }
    global $connection;
    $unos = unesiNovoPitanjeAnketa($pitanje);
    $poslednji = $connection->lastInsertId();
    $uneti = [];
    foreach ($survey as $odgovor){
       $rez = unesiNoveOdgovoreAnketa($poslednji, $odgovor);
       if(!$rez){
           $uneti [] = 'greska';
       }
    }
    if(!count($uneti)){
        $_SESSION['unosSurvey'] = 'You have successfully added a survey.';
        header('Location: ../adminPanel.php');
        die();
    }
    else{
        $_SESSION['unosNoSurvey'] = 'There was an error inserting a new survey.';
        header('Location: ../adminPanel.php');
        die();
    }

}
else{
    header('Location: ../error404.php');
}