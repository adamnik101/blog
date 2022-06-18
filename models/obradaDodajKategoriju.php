<?php
session_start();
if(isset($_SESSION['korisnik'])&& $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $kat = $_POST['newKat'];
    $katReg = '/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,19}(\s[a-zšđčćž]{2,19})*$/';
    if(!preg_match($katReg,$kat)){
        $err++;
        $_SESSION['katErr'] = 'Category name must start with uppercase letter and cannot contain symbols or digits.';
        header('Location: ../adminPanel.php');
    }
    if(isset($kat) && !isset($err)){
        $dodaj = dodajKategoriju($kat);
        if($dodaj){
            $_SESSION['katSucces'] = '<p class="alert alert-success mt-2">You have successfully added a category.</p>';
            header('Location: ../adminPanel.php');
        }
        else{
            http_response_code(500);
            $odgovor = ['msg' => 'There was an error with inserting data'];
            echo json_encode($odgovor);
        }
    }
    else{
        http_response_code(500);
        $odgovor = ['msg' => 'There was an error'];
        echo json_encode($odgovor);
    }

}
else{
    header('Location: ../error404.php');
}