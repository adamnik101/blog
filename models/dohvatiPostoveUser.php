<?php
session_start();
    if(isset($_SESSION['korisnik'])){
        header("Content-type: application/json");
        include_once '../config/connection.php';
        include_once 'functions.php';
        $id = $_SESSION['korisnik']->id_kor;
        $id_uloge = $_SESSION['korisnik']->id_uloga;
        if($id_uloge != 1){
            $dohvati = getUserPosts($id);
            if($dohvati->rowCount() >= 1) {
                $odgovor = $dohvati->fetchAll();
                echo json_encode($odgovor);
                http_response_code(200);
            }
            else{
                $odgovor = ['msg' => 'There is 0 posts created by you.'];
                echo json_encode($odgovor);
            }
        }
        else{
            $dohvati = getAllData('post');
            if($dohvati){
                $odgovor = $dohvati;
                echo json_encode($odgovor);
                http_response_code(200);
            }
            else{
                $odgovor = ['msg' => 'There is 0 posts to show.'];
                echo json_encode($odgovor);
            }
        }
    }
    else{
        header("Location: ../error404.php");
    }

?>