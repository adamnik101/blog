<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        session_start();
        include_once '../config/connection.php';
        include_once 'functions.php';
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $emailReg = '/^[a-z][a-z\.\d\-\_]+\@[a-z]+(\.[a-z]+)+$/';
        $passReg = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
        $brojGresaka = 0;
        if(isset($email)){
           if(!preg_match($emailReg, $email)){
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
        if(!$brojGresaka){
            $provera = proveriLogovanje($email, $pass);

            if(!is_null($provera->id_kor)){
                $_SESSION['korisnik'] = $provera;
                $odgovor = ['msg' => 'Uspesno ste se ulogovali.'];
                http_response_code(200);
                echo json_encode($odgovor);
            }
            else{
                $odgovor = ['msg'=>'Wrong combination of email/password.'];
                http_response_code(401);
                echo json_encode($odgovor);
            }
        }
    }
    else{
        header("Location: ../error404.php");
    }

?>