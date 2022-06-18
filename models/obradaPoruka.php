<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    if(isset($_POST['sendMessageAdmin'])){
        $fullname = addslashes($_POST['nameContact']);
        $email = addslashes($_POST['emailContact']);
        $message = strip_tags($_POST['messageContact']);
        $brojGresaka = 0;
        $fullnameReg = '/^([\w]{3,})+\s+([\w\s]{3,})+$/i';
        $emailReg = '/^[a-z][a-z\.\d\-\_]+\@[a-z]+(\.[a-z]+)+$/';
        $messReg = "/^.{20,500}$/";
        if(!preg_match($emailReg, $email)){
            $brojGresaka++;
            $_SESSION['mailErr'] = 'E.q. johndoe@gmail.com';
        }
        if(!preg_match($fullnameReg, $fullname)){
            $brojGresaka++;
            $_SESSION['nameErr'] = 'First name/last name must contain at least 3 letters';
        }

        if(!preg_match($messReg, $message)) {
            $brojGresaka++;
            $_SESSION['messErr'] = 'Message length must be between 20 and 500 letters';
        }
        try {
            if ($brojGresaka) {
                header("Location: ../contact.php");
            }
            else {
                $posalji = unesiPoruku($fullname, $email, addslashes($message));
                if ($posalji) {
                    $_SESSION['wow'] = 1;
                        header("Location: ../contact.php");
                }
            }
        } catch (PDOException $exception) {
            $_SESSION['dbErr'] = 'Error send a message, try again.';
            header("Location: ../contact.php");
        }
}
}
else{
        header("Location: ../error404.php");
}
?>