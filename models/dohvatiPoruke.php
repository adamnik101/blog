<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    header("Content-type: application/json");
    include_once '../config/connection.php';
    include_once 'functions.php';
    $broj = 1;
    try{
            $dohvati = getAllData('poruke');
            if($dohvati) {
                $messages = $dohvati;
                $ispis = '<h3 class="mt-0 mt-xl-5">All Messages</h3>';
                $ispis.= '<div class="table-responsive"><table class="table table-hover">';
                $ispis.='<thead class="thead-dark">';
                $ispis.='<th>#</th>';
                $ispis.='<th>Full name</th>';
                $ispis.='<th>Email</th>';
                $ispis.='<th>Message</th>';
                $ispis.='<th>Delete</th>';
                $ispis.='</tr></thead class="thead-dark">';
                foreach ($messages as $message){
                    $ispis.='<tr>';
                    $ispis.='<td>'.$broj++.'</td>';
                    $ispis.='<td>'.stripslashes($message->imePrezime).'</td>';
                    $ispis.='<td>'.stripslashes($message->email).'</td>';
                    $ispis.='<td>'.stripslashes($message->poruka).'</td>';
                    $ispis.='<td><button type="button" class="dgm delMessage btn btn-danger" data-message="'.$message->id.'">Delete</button></td>';
                }
                $ispis.='</table></div>';
                http_response_code(200);
                echo json_encode($ispis);
            }
            else {
                http_response_code(500);
                $odgovor = ['msg' => 'You got 0 messages.'];
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