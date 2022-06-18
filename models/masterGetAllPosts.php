<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $dohvati = getAllPostsMaster();
    if($dohvati){
        $broj = 1;
        $postovi = $dohvati;
        $ispis = '<h3 class="mt-0 mt-xl-5">All posts</h3>';
        $ispis.= '<div class="table-responsive"><table class="table table-hover">';
        $ispis.='<thead class="thead-dark">';
        $ispis.='<th>#</th>';
        $ispis.='<th>Headline</th>';
        $ispis.='<th>Date created</th>';
        $ispis.='<th>Autor</th>';
        $ispis.='<th>Edit</th>';
        $ispis.='<th>Delete</th>';
        $ispis.='</tr></thead class="thead-dark">';
        foreach ($postovi as $post){
            $ispis.='<tr>';
            $ispis.='<td>'.$broj++.'</td>';
            $ispis.='<td>'.substr_replace(stripslashes($post->naslov), '...', 20).'</td>';
            $ispis.='<td>'.$post->datum.'</td>';
            $ispis.='<td>'.stripslashes($post->imePrezime).'</td>';
            $ispis.='<td><button type="button" class="dgm editPost btn btn-primary" data-post="'.$post->id_post.'">Edit</button></td>';
            $ispis.='<td><button type="button" class="dgm delPost btn btn-danger" data-post="'.$post->id_post.'">Delete</button></td>';
        }
        $ispis.='</table></div>';
        http_response_code(200);
        echo json_encode($ispis);
    }
    else{
        http_response_code(500);
        $odgovor = ['msg' => 'There are no posts to show.'];
        echo json_encode($odgovor);
    }

}
else{
    header("Location: ../error404.php");
}
