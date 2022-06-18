<?php
session_start();
if(isset($_SESSION['korisnik'])&& $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $kat = $_POST['naslovKat'];
    $kat_id = $_POST['izmeniKat'];
    $katReg = '/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,19}(\s[a-zšđčćž]{2,19})*$/';
    if(!preg_match($katReg,$kat)){
        $err++;
        $_SESSION['katErr'] = 'Category name must start with uppercase letter and cannot contain symbols or digits.';
        header('Location: ../adminPanel.php');
        die();
    }
    if(isset($kat) && !isset($err) && isset($kat_id)){
        $dohvatiKategoriju = getCatEdit($kat_id);
        if($dohvatiKategoriju){
            $izmeni = izmeniKategoriju($dohvatiKategoriju->id, $kat);
            if($izmeni){
                $_SESSION['katSucces'] = '<p class="alert alert-success mt-2">You have successfully updated a category.</p>';
                header('Location: ../adminPanel.php');
                die();
            }
            else{
                $_SESSION['katErr'] = 'Looks like you did not change category name';
                header('Location: ../adminPanel.php');
                die();
            }
        }
        else{
            $_SESSION['katErr'] = 'There was an error with fetching category data';
            header('Location: ../adminPanel.php');
            die();
        }

    }
    else{
        $_SESSION['katErr'] = 'There was an error.';
        header('Location: ../adminPanel.php');
        die();
    }
}
else{
    header('Location: ../error404.php');
}