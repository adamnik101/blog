<?php
session_start();
if(isset($_SESSION['korisnik']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/connection.php';
    include_once 'functions.php';
    header('Content-type: application/json');
    $id_post = $_POST['id_post'];
    if(isset($id_post)){
        $post = getPostData($id_post)->fetch();
        if(isset($post)){
            $naslov = $post->naslov;
            $kat_id = $post->kat_id;
            $dohvatiKat = getCategories();
            $tekst =$post->tekst;
            $kategorija = $post->naziv_kat;
            $ispis = '';
            $ispis.='<form class="mt-5" enctype="multipart/form-data" onSubmit="return dodajPost();" action="models/obradaPost.php" method="POST"><label for="naslovPost" class="my-1">Headline:</label><input type="text" id="naslovPost" value="'.stripslashes($naslov).'" name="naslovPost" class="form-control">';
            $ispis.='<label for="slika" class="my-1">Choose new image:[optional]</label><input type="file" id="slika" data-optional="1" value="'.$post->slika.'" name="slika" class="form-control-file">';
            $ispis.="<p>Image already posted:</p><div class='col-lg-6 col'> <img src='img/".$post->slika."' class='img-fluid' /></div>";
            $ispis.='<label for="postCat" class="my-1 d-block">Categories:</label><select name="postCat" class="form-control" id="postCat">';
            foreach ($dohvatiKat as $kat){
                if($kat->id == $kat_id){
                    $ispis.='<option value="'.$kat->id.'" selected>'.$kat->naziv.'</option>';
                }
                else{
                    $ispis.='<option value="'.$kat->id.'">'.$kat->naziv.'</option>';
                }

            }
            $ispis.='</select>';
            $ispis.='<label for="tekstPost" class="my-1">Text content:</label><textarea rows="20" type="text" name="tekstPost" id="tekstPost" class="form-control">'.stripslashes($tekst).'</textarea>';
            $ispis.='<button id="promeniPost" type="submit" class="my-1 btn btn-dark" data-id="'.$id_post.'" value="'.$id_post.'" name="promeniPost">Update post</button></form>';
            echo json_encode($ispis);
            http_response_code(200);
        }
    }
    else{
        $odgovor = ['msg' => 'Error with getting post data'];
        echo json_encode($odgovor);
        http_response_code(500);
    }

}
else{
    header('Location: ../error404.php');
}