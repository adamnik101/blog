<?php
session_start();
if(isset($_POST['email']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $mail = $_POST['email'];
    $emailReg = '/^[a-z][a-z\.\d\-\_]+\@[a-z]+(\.[a-z]+)+$/';
    if(!preg_match($emailReg, $mail)){
        $odg = ['msg' => 'E.q. johndoe@gmail.com'];
        echo json_encode($odg);
        http_response_code(500);
    }
    else{
        try {
            $unos = unesiMail($mail);
            if(is_null($unos)){
                throw $exception = new Exception('already exists');
            }
            if($unos->rowCount() == 1){
                $odg = ['msg' => 'You have successfully subscribed to our newsletter.'];
                echo json_encode($odg);
                http_response_code(200);
            }

        }
        catch (Exception $exception){
            $odg = ['msg' => 'Oops. Looks like that email is already subscribed.'];
            echo json_encode($odg);
            http_response_code(500);
        }

    }


}
else{
    header('Location: ../error404.php');
}