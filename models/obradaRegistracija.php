<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    ini_set('SMTP', 'localhost');
    ini_set('smtp_port', 25);
    try{
        $fullname = addslashes($_POST['imePrezime']);
        $email = addslashes($_POST['email']);
        $pass = addslashes($_POST['password']);
        $passConfirm = $_POST['passwordConfirm'];
        $brojGresaka = 0;

        $fullnameReg = '/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,})+$/';
        $emailReg = '/^[a-z][a-z\.\d\-\_]+\@[a-z]+(\.[a-z]+)+$/';
        $passReg = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        $id_uloge = 2;
        $status = 0;
        $dataToSend = [$id_uloge, $status];
        if(isset($fullname)){
            if(preg_match($fullnameReg, $fullname)){
                array_push($dataToSend, $fullname);
            }
            else{
                $brojGresaka++;
            }
        }
        else{
            $brojGresaka++;
        }
        if(isset($email)){
            if(preg_match($emailReg, $email)){
                array_push($dataToSend, $email);
            }
            else{
                $brojGresaka++;
            }
        }
        else{
            $brojGresaka++;
        }
        if(isset($pass)){
            if(!preg_match($passReg, $pass)){
                $brojGresaka++;
            }
        }
        else{
            $brojGresaka++;
        }
        if(isset($passConfirm)){
            if($pass == $passConfirm){
                if(preg_match($passReg, $passConfirm)){
                    $encryptedPass = md5($passConfirm);
                    array_push($dataToSend, $encryptedPass);
                }
                else{
                    $brojGresaka++;
                }
            }
            else{
                $brojGresaka++;
            }
        }
        else{
            $brojGresaka++;
        }

        if(!$brojGresaka){
            try{
                $unosKorisnika = unesiKorisnika($dataToSend);
                if($unosKorisnika){
                    $mail = mail("adamnikolic951@gmail.com", 'something', 'ayeee les go');
                    $odgovor = ['msg' => 'You have successfully registered'];
                    echo json_encode($odgovor);
                    http_response_code(201);
                }
            }catch (PDOException $exception){
                $odgovor = ['msg'=>'Oops, looks like there\'s already an account linked to that email.'];
                http_response_code(500);
                echo json_encode($odgovor);
            }
        }
    }
    catch (PDOException $exception){
        http_response_code(500);
    }

}
else{
    header("Location: ../error404.php");
}
?>