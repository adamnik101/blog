<?php
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    include_once "config/connection.php";
    include_once "models/functions.php";
    $podaci = getAllUsers();
    $postovi = getLatestPosts(4);
    $korisniciPoslednji = getLatestUsersRegistered();
    $broj = 1;
}
else{
    header("Location: ../error404.php");
}

?>
