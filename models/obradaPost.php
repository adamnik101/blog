<?php  session_start();
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['korisnik']) && isset($_POST['posaljiPost']) || isset($_POST['promeniPost'])){
    include_once '../config/connection.php';
    include_once 'functions.php';
    $id_kor = $_SESSION['korisnik']->id_kor;
    $naslov = addslashes($_POST['naslovPost']);
    $kat_id = $_POST['postCat'];
    $tekst = strip_tags($_POST['tekstPost']);
    $file = $_FILES['slika'];
    $nameFile = $file['name'];
    $tmpFile = $file['tmp_name'];
    $err = $file['error'];
    $size = $file['size'];
    $type = $file['type'];
    $types = ['image/jpeg', 'image/jpg', 'image/png'];
    $limit = 2;
    $errCount = 0;
    $korisnikGreske = [];
    $naslovReg = '/^[A-Z0-9][a-z0-9]+(\s\w+|\d+|\W)+/';
    if (!isset($naslov)){
        $korisnikGreske [] = "Please enter headline.";
    }
    if(!preg_match($naslovReg, $naslov)){
        $korisnikGreske [] = "Title must start with capital letter, it can contain non-letter character.";
    }
    if(strlen($naslov) < 20 || strlen($naslov) > 100){
        $korisnikGreske [] = "Headline must contain min 20 letters and max 100 letter";
    }
    if(!isset($tekst)){
        $korisnikGreske [] = "Please enter post content.";
    }
    if(strlen($tekst) < 150){
        $korisnikGreske [] = "Post content must contain min 150 letters.";
    }
    if(isset($_POST['promeniPost']) && !count($korisnikGreske)){
        $id_post = $_POST['promeniPost'];
        if($file['size']){
            // ako je ubacena slika
            $dohvatiTajPost = getPostData($id_post);
            if($dohvatiTajPost->rowCount() == 1){
                if(!$err){
                    if(!in_array($type, $types)){
                        $errCount++;
                        $_SESSION['errType'] = 'You must upload images with .jpeg . jpg .png';
                    }
                    if($size > (1024*1021 * 2)){
                        $errCount++;
                        $_SESSION['errSize'] = 'File cannot be larger than 2MB';
                    }
                }
                if($errCount){
                    if(strpos($_SERVER['HTTP_REFERER'], 'adminPanel')){
                        header("Location: ../adminPanel.php");
                    }
                    else{
                        header("Location: ../createPost.php");
                    }
                }
                else{
                    $imeFajla = time().'_'.$nameFile;
                    $loc = '../img/'.$imeFajla;
                    if(move_uploaded_file($tmpFile, $loc)){
                        $izmeni = updatePostSaSlikom($naslov, $kat_id, $imeFajla, addslashes($tekst) , $id_post);
                        if($izmeni){
                            header('Location: ../blog-details.php?id='.$id_post);
                        }
                        else{
                            if(strpos($_SERVER['HTTP_REFERER'], 'adminPanel')){
                                header("Location: ../adminPanel.php");
                            }
                            else{
                                header("Location: ../createPost.php");
                            }
                        }
                    }
                    else{
                        echo 'nope';
                    }
                }
            }
        }
        else{
            $izmeni = updatePostBezSlike($naslov, $kat_id, addslashes($tekst), $id_post);
            if($izmeni){
                header('Location: ../blog-details.php?id='.$id_post);
            }
        }
        die();
    }
    $errCount = 0;
    if(!$err){
        if(!in_array($type, $types)){
            $errCount++;
            $_SESSION['errType'] = 'You must upload images with .jpeg . jpg .png';
        }
        if($size > (1024*1021 * 2)){
            $errCount++;
            $_SESSION['errSize'] = 'File cannot be larger than 2MB';
        }
    }
    if($errCount){
        if(strpos($_SERVER['HTTP_REFERER'], 'adminPanel')){
            header("Location: ../adminPanel.php");
        }
        else{
            header("Location: ../createPost.php");
        }
    }
    else{
        $imeFajla = time().'_'.$nameFile;
        $loc = '../img/'.$imeFajla;
        if(move_uploaded_file($tmpFile, $loc)){
            $insertFile = dodajPost($naslov, $kat_id, $imeFajla, addslashes($tekst) ,$id_kor);
            if($insertFile){
                header('Location: ../blog.php');
            }
            else{
                $_SESSION['errUnos'] = 'Failed to post.';
            }
        }
        else{
            $_SESSION['errMove'] = 'Failed to send image.';
        }
    }
}
else{
    header("Location: ../error404.php");
}

?>