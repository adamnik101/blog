<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['korisnik']->id_uloga == 1){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
        $news = getNews();
    if($news){
        $broj = 1;
        $postovi = $news;
        $ispis = '<h3 class="mt-0 mt-xl-5">All newsletters</h3>';
        $ispis.= '<div class="table-responsive"><table class="table table-hover">';
        $ispis.='<thead class="thead-dark">';
        $ispis.='<th>#</th>';
        $ispis.='<th>Email</th>';
        $ispis.='<th>Date subscribed</th>';
        $ispis.='<th>Delete</th>';
        $ispis.='</tr></thead class="thead-dark">';
        foreach ($news as $sub){
            $ispis.='<tr>';
            $ispis.='<td>'.$broj++.'</td>';
            $ispis.='<td>'.$sub->email.'</td>';
            $ispis.='<td>'.$sub->datum_prijave.'</td>';
            $ispis.='<td><button type="button" class="dgm delNewsletter btn btn-danger" data-post="'.$sub->id.'">Delete</button></td>';
        }
        $ispis.='</table></div>';
        http_response_code(200);
        echo json_encode($ispis);
    }
    else{
        http_response_code(500);
        $odgovor = ['msg' => 'There are no newsletter to show.'];
        echo json_encode($odgovor);
    }
}
else{
    header('Location: ../error404.php');
}