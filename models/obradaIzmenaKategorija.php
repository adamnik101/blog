<?php
session_start();
if(isset($_SESSION['korisnik'])&& $_SESSION['korisnik']->id_uloga == 1 && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_kat = $_POST['id_cat'];
    if(isset($id_kat)){
        $kat = getCatEdit($id_kat);
        if($kat){
            $naslov = $kat->naziv;
            $kat_id = $kat->id;
            $ispis = '';
            $ispis.='<form class="mt-5" onSubmit="return proveriKat();" action="models/obradaKategorije.php" method="POST"><label for="naslovKat" class="my-1">Category name:</label><input type="text" id="addKat" value="'.stripslashes($naslov).'" name="naslovKat" class="form-control"> <button type="submit" name="izmeniKat" value="'.$kat_id.'" class="btn btn-secondary mt-3" data-cat="'.$kat_id.'">Update</button>';
            http_response_code(200);
            echo json_encode($ispis);
        }
        else{
            http_response_code(500);
            $odgovor = ['msg' => 'There was an error with category data'];
            echo json_encode($odgovor);
        }
    }
    else{
        http_response_code(500);
        $odgovor = ['msg' => 'There was an error.'];
        echo json_encode($odgovor);
    }

}
else{
    header('Location: ../error404.php');
}