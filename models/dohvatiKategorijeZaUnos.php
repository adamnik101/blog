<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    $broj = 1;
    try{
        $dohvati = getAllData('kategorija_post');
        if($dohvati) {
            $messages = $dohvati;
               $ispis = '';
               foreach ($dohvati as $kat){
                   $ispis.='<option value="'.$kat->id.'">'.$kat->naziv.'</option>';
               }
            http_response_code(200);
            echo json_encode($ispis);
        }
        else {
            http_response_code(500);
            $odgovor = ['msg' => 'There is no categories. You might want to add some.'];
            echo json_encode($odgovor);
        }
    }
    catch (PDOException $exception){
        http_response_code(500);
        $odgovor = ['msg' =>'Error fetching data from database'];
        echo json_encode($odgovor);
    }

}
else{
    header("Location: ../error404.php");
}

?>