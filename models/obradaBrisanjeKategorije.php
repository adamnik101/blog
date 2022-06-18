<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['korisnik']->id_uloga == 1){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_cat = $_POST['id_cat'];
    if(isset($id_cat)){
        $obrisi = deleteCategory($id_cat);
        if(isset($obrisi)){
            $odgovor = ['msg' => 'You have successfully deleted a category.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
        else{
            $odgovor = ['msg' => 'There was an error deleting a category.'];
            echo json_encode($odgovor);
            http_response_code(500);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with getting category data'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}