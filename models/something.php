<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    include_once '../config/connection.php';
    include_once 'functions.php';
    $email = $_POST['email'];

}
else{
    header("Location: ../error404.php");
}

?>