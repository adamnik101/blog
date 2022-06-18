<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $dohvati = getAllUsers();
    if($dohvati->rowCount() >= 1){
        $broj = 1;
        $korisnici = $dohvati->fetchAll();
        $ispis = '<h3 class="mt-xl-5 mt-0">All users</h3>';
        $ispis.= '<div class="table-responsive"><table class="table table-hover">';
                $ispis.='<thead class="thead-dark">';
                $ispis.='<th>#</th>';
                $ispis.='<th>Full name</th>';
                $ispis.='<th>Date Joined</th>';
                $ispis.='<th>Email</th>';
                $ispis.='<th>Delete</th>';
                $ispis.='</tr></thead class="thead-dark">';
                foreach ($korisnici as $korisnik){
                    $ispis.='<tr>';
                    $ispis.='<td>'.$broj++.'</td>';
                    $ispis.='<td>'.$korisnik->imePrezime.'</td>';
                    $ispis.='<td>'.date($korisnik->vremeKreiranja).'</td>';
                    $ispis.='<td>'.$korisnik->email.'</td>';
                    $ispis.='<td><button type="button" class="dgm delUser btn btn-danger" data-user="'.$korisnik->id.'">Delete</button></td>';
                }
                $ispis.='</table></div>';
        http_response_code(200);
        echo json_encode($ispis);
    }
    else{
        http_response_code(500);
        $odgovor = ['msg' => 'There are no users registered.'];
        echo json_encode($odgovor);
    }

}
else{
    header("Location: ../error404.php");
}
