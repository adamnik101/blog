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
            $ispis = '<h3 class="mt-0 mt-xl-5">All categories</h3>';
            $ispis.= '<div class="table-responsive"><table class="table table-hover">';
            $ispis.='<thead class="thead-dark">';
            $ispis.='<th>#</th>';
            $ispis.='<th>Naziv</th>';
            $ispis.='<th>Edit</th>';
            $ispis.='<th>Delete</th>';
            $ispis.='</tr></thead class="thead-dark">';
            foreach ($messages as $message){
                $ispis.='<tr>';
                $ispis.='<td>'.$broj++.'</td>';
                $ispis.='<td>'.ucfirst($message->naziv).'</td>';
                $ispis.='<td><button type="button" class="dgm editCat btn btn-primary" data-category="'.$message->id.'">Edit</button></td>';
                $ispis.='<td><button type="button" class="dgm delCat btn btn-danger" data-category="'.$message->id.'">Delete</button></td>';
            }
            $ispis.='</table></div>';
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