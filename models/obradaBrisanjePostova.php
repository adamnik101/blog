<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_post = $_POST['id_post'];
    if(isset($id_post)){
        $post = deletePost($id_post);
        if(isset($post)){
            $odgovor = ['msg' => 'You have successfully deleted a post.'];
            echo json_encode($odgovor);
            http_response_code(200);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with getting post data'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}