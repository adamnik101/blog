<?php
function getAllData($tabela){
    global $connection;
    $upit = "SELECT * FROM $tabela";
    $priprema = $connection->prepare($upit);
    $priprema->execute();
    return $priprema->fetchAll();
}
function unesiKorisnika($data){
    global $connection;
    $upit = "INSERT INTO korisnik (imePrezime, email, lozinka, id_uloge, aktivan) VALUES(:imePrezime, :email, :lozinka, :id_uloge, :aktivan)";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":imePrezime", $data[2]);
    $priprema->bindParam(":email", $data[3]);
    $priprema->bindParam(":lozinka", $data[4]);
    $priprema->bindParam(":id_uloge", $data[0]);
    $priprema->bindParam(":aktivan", $data[1]);
    $rezultat = $priprema->execute();
    return $rezultat;
}
function proveriLogovanje($email, $pass){
    global $connection;
    $encrypted = md5($pass);
    $upit = "SELECT k.id AS id_kor, k.imePrezime AS imePrezime, k.email AS email, u.naziv AS uloga, u.id AS id_uloga,COUNT(p.id) AS brojPostova, k.vremeKreiranja AS vremeKreiranja FROM korisnik k INNER JOIN uloge u ON k.id_uloge = u.id INNER JOIN post p ON p.korisnik_id = k.id  WHERE k.email = :email AND k.lozinka = :lozinka";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(':email', $email);
    $priprema->bindParam(':lozinka', $encrypted);
    $priprema->execute();
    return $priprema->fetch();
}
function dodajPost($naslov, $kat_id, $putanja, $tekst, $kor_id){
    global $connection;
    try {
        $upit = "INSERT INTO post (naslov, korisnik_id, kategorija_id, slika_src, tekst) VALUES(:naslov, :kor_id, :kat_id, :slika, :tekst)";
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(":naslov", $naslov);
        $priprema->bindParam(":kor_id", $kor_id);
        $priprema->bindParam(":kat_id", $kat_id);
        $priprema->bindParam(":slika", $putanja);
        $priprema->bindParam(":tekst", $tekst);
        $priprema->execute();
        return $connection->lastInsertId();
    }
    catch (PDOException $exception){
        echo $exception->getMessage();
    }
}
function dohvatiPostove($limit, $offset){
    global $connection;
    $upit = "SELECT p.id AS id_post, p.slika_src AS slika, p.naslov AS naslov, p.korisnik_id AS id_kor, p.tekst AS tekst, kat.naziv AS naziv_kategorije, p.datum AS vremeKreiranja, count(kom.id_post) AS komentar, k.imePrezime AS imePrezime FROM post p LEFT JOIN komentar kom ON p.id = kom.id_post LEFT JOIN korisnik k ON p.korisnik_id = k.id LEFT JOIN kategorija_post kat ON p.kategorija_id = kat.id GROUP BY p.id ORDER BY p.datum DESC LIMIT :limit OFFSET :offset ";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":limit", $limit, PDO::PARAM_INT);
    $priprema->bindParam(":offset", $offset, PDO::PARAM_INT);
    $priprema->execute();
    return $priprema->fetchAll();
}
function dohvatiPostovePoBrojuKomentara($limit, $offset){
    global $connection;
    $upit = "SELECT p.id AS id_post, p.slika_src AS slika, p.naslov AS naslov, p.korisnik_id AS id_kor, p.tekst AS tekst, kat.naziv AS naziv_kategorije, p.datum AS vremeKreiranja, count(kom.id_post) AS komentar, k.imePrezime AS imePrezime FROM post p LEFT JOIN komentar kom ON p.id = kom.id_post LEFT JOIN korisnik k ON p.korisnik_id = k.id LEFT JOIN kategorija_post kat ON p.kategorija_id = kat.id GROUP BY p.id ORDER BY komentar DESC LIMIT :limit OFFSET :offset ";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":limit", $limit, PDO::PARAM_INT);
    $priprema->bindParam(":offset", $offset, PDO::PARAM_INT);
    $priprema->execute();
    return $priprema->fetchAll();
}
function getLatestPosts($broj){
    global $connection;
    $upit = "SELECT * FROM post ORDER BY datum DESC LIMIT :broj";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":broj", $broj, PDO::PARAM_INT);
    $priprema->execute();
    return $priprema->fetchAll();
}
function showRole($kor_id){
    global $connection;
    $upit = "SELECT naziv FROM uloge WHERE id = :kor_id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(':kor_id', $kor_id);
    $priprema->execute();
    $rezultat = $priprema->fetch();
    return $rezultat->naziv;
}
function getUserPosts($id, $limit, $offset){
    global $connection;
    $upit = "SELECT * FROM post WHERE korisnik_id = :kor_id LIMIT :limit OFFSET :offset";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":kor_id", $id);
    $priprema->bindParam(":limit", $limit, PDO::PARAM_INT);
    $priprema->bindParam(":offset", $offset, PDO::PARAM_INT);
    $priprema->execute();
    $rezultat = $priprema->fetchAll();
    return $rezultat;
}
function getUserCreator($id){
    global $connection;
    $upit = "SELECT * FROM korisnik WHERE id = :kor_id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":kor_id", $id);
    $priprema->execute();
    $rezultat = $priprema->fetch();
    return $rezultat->imePrezime;
}
function deleteUser($id_kor){
    global $connection;
    $upit = "DELETE FROM korisnik WHERE id = :id_kor";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id_kor", $id_kor);
    $priprema->execute();
    $rezultat = $priprema;
    return $rezultat;
}
function editPost($naslov, $tekst, $id_post){
    global $connection;
    $upit = "UPDATE post SET naslov = :naslov, tekst = :tekst WHERE id = :id_post";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":naslov", $naslov);
    $priprema->bindParam(":tekst", $tekst);
    $priprema->bindParam(":id_post", $id_post);
    $priprema->execute();
    $rezultat = $priprema;
    return $rezultat;
}
function getSearchHeadline($text){
    global $connection;
    $upit = "SELECT * FROM post WHERE naslov LIKE CONCAT('%', :text, '%')";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":text", $text);
    $priprema->execute();
    $rezultat = $priprema->fetchAll();
    return $rezultat;
}
function getPostData($id){
    global $connection;

    $upit = "SELECT k.imePrezime AS imePrezime, p.slika_src AS slika, p.kategorija_id AS kat_id, p.slika_src AS slika, p.datum AS datum, p.id AS id_post,p.tekst AS tekst, p.naslov AS naslov, k.id AS id, k2.naziv AS naziv_kat FROM post p JOIN korisnik k ON p.korisnik_id = k.id JOIN kategorija_post k2 ON k2.id = p.kategorija_id WHERE p.id = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id);
    $priprema->execute();
    $rezultat = $priprema;
    return $rezultat;
}
function brojKomentara($id){
    global $connection;
    $upit = "SELECT COUNT(*) AS brojKomentara FROM komentar WHERE id_post = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id);
    $priprema->execute();
    $rezultat = $priprema->fetch();
    return $rezultat->brojKomentara;
}
function dohvatiKomentare($id){
    global $connection;
    $upit = "SELECT k1.id AS id, k.imePrezime AS imePrezime, k1.text AS tekst, k.id AS id_kor, k1.vreme_unosa AS datum FROM komentar k1 JOIN korisnik k ON k.id = k1.id_kor WHERE k1.id_post = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id);
    $priprema->execute();
    $rezultat = $priprema->fetchAll();
    return $rezultat;
}
function unesiKomentar($poruka, $id_post, $id_kor){
    global $connection;
    $upit = "INSERT INTO komentar (text, id_post, id_kor) VALUES (:tekst, :id_post, :id_kor)";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":tekst", $poruka);
    $priprema->bindParam(":id_post", $id_post);
    $priprema->bindParam(":id_kor", $id_kor);
    $priprema->execute();
    $rezultat = $priprema;
    return $rezultat;
}
function getAllUsers(){
    global $connection;

    $upit = "SELECT id, imePrezime, email, vremeKreiranja FROM korisnik WHERE id_uloge NOT IN(1)";
    $rezultat = $connection->query($upit);
    return $rezultat;
}
function getCountUserPosts($id){
    global $connection;

    $upit = "SELECT COUNT(p.id) AS brojPostova FROM post p JOIN korisnik k ON p.korisnik_id = k.id WHERE p.korisnik_id =  :id";
    $rezultat = $connection->prepare($upit);
    $rezultat->bindParam(":id", $id);
    $rezultat->execute();
    return $rezultat->fetch();
}
function getLatestUsersRegistered(){
    global $connection;

    $upit = "SELECT id, imePrezime, email, vremeKreiranja FROM korisnik WHERE id_uloge NOT IN(1) ORDER BY vremeKreiranja DESC LIMIT 4 OFFSET 0";
    $rezultat = $connection->query($upit);
    return $rezultat;
}
function getCategories(){
    global $connection;
    $upit = "SELECT * FROM kategorija_post";
    $rezultat = $connection->query($upit);
    return $rezultat->fetchAll();
}
function updatePostBezSlike($naslov, $kat, $tekst, $id_post){
    global $connection;

    $upit = "UPDATE post SET naslov = :naslov, kategorija_id = :kat, tekst = :tekst WHERE id = :id_post";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":naslov", $naslov);
    $priprema->bindParam(":kat", $kat);
    $priprema->bindParam(":tekst", $tekst);
    $priprema->bindParam(":id_post", $id_post);
    $rezultat = $priprema->execute();
    return $rezultat;
}
function updatePostSaSlikom($naslov, $kat, $slika, $tekst, $id_post){
    global $connection;

    $upit = "UPDATE post SET naslov = :naslov, kategorija_id = :kat, slika_src = :slika, tekst = :tekst WHERE id = :id_post";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":naslov", $naslov);
    $priprema->bindParam(":kat", $kat);
    $priprema->bindParam(":slika", $slika);
    $priprema->bindParam(":tekst", $tekst);
    $priprema->bindParam(":id_post", $id_post);
    $rezultat = $priprema->execute();
    return $rezultat;
}
function deletePost($id){
    global $connection;

    $upit = "DELETE FROM post WHERE id = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id);
    $rezultat = $priprema->execute();
    return $rezultat;
}
function deleteComment($id){
    global $connection;

    $upit = "DELETE FROM komentar WHERE id = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id);
    $rezultat = $priprema->execute();
    return $rezultat;
}
function getAllPostsMaster(){
    global $connection;

    try{
        $upit = "SELECT p.id AS id_post, p.naslov AS naslov, p.datum AS datum, k.imePrezime AS imePrezime  FROM post p JOIN korisnik k ON k.id = p.korisnik_id";
        $rezultat = $connection->query($upit);
        return $rezultat->fetchAll();
    }
    catch (PDOException $exception){
        echo $exception->getMessage();
    }
}
function unesiMail($mail){
    global $connection;
    try {
        $upit = "INSERT INTO newsletter (email) VALUES(:mail)";
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(":mail", $mail);
        $priprema->execute();
        $rezultat = $priprema;
        return $rezultat;
    }
    catch (PDOException $exception){
    }
}
function getNews(){
    global $connection;
    $upit = 'SELECT * FROM newsletter';
    $rez = $connection->query($upit);
    return $rez->fetchAll();
}
function unesiPoruku($imePrezime, $email, $poruka){
    global $connection;

    try{
        $upit = 'INSERT INTO poruke (imePrezime, email, poruka) VALUES (:ime, :email, :poruka)';
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(':ime', $imePrezime, PDO::PARAM_STR);
        $priprema->bindParam(':email', $email, PDO::PARAM_STR);
        $priprema->bindParam(':poruka', $poruka, PDO::PARAM_STR);
        $priprema->execute();
        $rezultat = $priprema->rowCount();
        return $rezultat;
    }
    catch (PDOException $exception){
        echo 'Connection error with database: '.$exception->getMessage();
    }
}
function deleteNewsletter($id){
    global $connection;

        $upit = 'DELETE FROM newsletter WHERE id = :id';
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(':id', $id, PDO::PARAM_INT);
        $priprema->execute();
        $rezultat = $priprema->rowCount();
        return $rezultat;
}
function deleteMessage($id){
    global $connection;

    $upit = 'DELETE FROM poruke WHERE id = :id';
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(':id', $id, PDO::PARAM_INT);
    $priprema->execute();
    $rezultat = $priprema->rowCount();
    return $rezultat;
}
function getCatEdit($id){
    global  $connection;
    $upit = "SELECT * FROM kategorija_post WHERE id = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id, PDO::PARAM_INT);
    $priprema->execute();
    $rez = $priprema->fetch();
    return $rez;
}
function dodajKategoriju($kat){
    global $connection;

    $upit = 'INSERT INTO kategorija_post (naziv) VALUES (:kat)';
    try {
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(':kat', $kat);
        $priprema->execute();
        $rezultat = $priprema->rowCount();
        return $rezultat;
    }
    catch (PDOException $exception){
        echo $exception->getMessage();
    }
}
function deleteCategory($id){
    global $connection;
    try {
        $upit = "DELETE FROM kategorija_post WHERE id = :id";
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(":id", $id);
        $priprema->execute();
        $rez = $priprema->rowCount();
        return  $rez;
    }
    catch (PDOException $exception){
        echo $exception->getMessage();
    }
}
function izmeniKategoriju($id, $naziv){
    global $connection;
    try {
        $upit = "UPDATE kategorija_post SET naziv = :naziv WHERE id = :id";
        $priprema = $connection->prepare($upit);
        $priprema->bindParam(":id", $id, PDO::PARAM_INT);
        $priprema->bindParam(":naziv", $naziv, PDO::PARAM_STR);
        $priprema->execute();
        $rez = $priprema->rowCount();
        return  $rez;
    }
    catch (PDOException $exception){
        echo $exception->getMessage();
    }
}
function dohvatiAnketu(){
    global $connection;
    $upit = "SELECT s.pitanje AS pitanje, so.odgovor AS odgovor, ROUND (COUNT(sko.korisnik_id) / (SELECT COUNT(sko.korisnik_id) FROM survey_korisnik_odgovor sko LEFT JOIN survey s ON sko.id_survey = s.id WHERE s.active = 1) * 100, 2) AS procenat FROM survey s LEFT JOIN survey_odgovori so ON s.id = so.id_survey LEFT JOIN survey_korisnik_odgovor sko ON s.id = sko.id_survey WHERE sko.id_odgovor = so.id_odgovor AND s.active = 1 GROUP BY so.id_odgovor";
    $prepare  = $connection->prepare($upit);
    $prepare->execute();
    $rez = $prepare->fetchAll();
    return $rez;
}
function proveriAnketuKorisnika($id){
    global $connection;
    $upit = "SELECT sko.korisnik_id FROM survey_korisnik_odgovor sko LEFT JOIN survey s ON sko.id_survey = s.id WHERE korisnik_id = :id";
    $prepare  = $connection->prepare($upit);
    $prepare->bindParam(':id', $id, PDO::PARAM_INT);
    $prepare->execute();
    $rez = $prepare->rowCount();
    return $rez;
}
function dohvatiFormuZaAnketu(){
    global $connection;
    $upit = "SELECT s.id AS id_survey, s.pitanje AS pitanje, so.odgovor AS odgovor, so.id_odgovor AS id_odgovor FROM survey s LEFT JOIN survey_odgovori so ON s.id = so.id_survey WHERE s.active = 1";
    $prepare  = $connection->prepare($upit);
    $prepare->execute();
    $rez = $prepare->fetchAll();
    return $rez;
}
function unesiOdgovor($survey, $odgovor, $korisnik){
    global $connection;
    $upit = "INSERT INTO survey_korisnik_odgovor (id_survey, id_odgovor, korisnik_id) VALUES (:survey, :odgovor, :korisnik)";
    $prepare  = $connection->prepare($upit);
    $prepare->bindParam(":survey", $survey, PDO::PARAM_INT);
    $prepare->bindParam(":odgovor", $odgovor, PDO::PARAM_INT);
    $prepare->bindParam(":korisnik", $korisnik, PDO::PARAM_INT);
    $prepare->execute();
    $rez = $prepare->rowCount();
    return $rez;
}
function dohvatiSveAnkete(){
    global $connection;
    $upit = "SELECT s.pitanje AS pitanje, s.id AS id, s.active AS active FROM survey s LEFT JOIN survey_odgovori so ON s.id = so.id_survey GROUP BY s.id";
    $prepare  = $connection->prepare($upit);
    $prepare->execute();
    $rez = $prepare->fetchAll();
    return $rez;
}
function aktivirajAnketu($id){
    global $connection;
    $upit = "UPDATE survey SET active = 0";
    $deactivateAll = $connection->prepare($upit);
    $deactivateAll->execute();
    $activateOneQuery = 'UPDATE survey SET active = 1 WHERE id = :id';
    $activate = $connection->prepare($activateOneQuery);
    $activate->bindParam(":id", $id, PDO::PARAM_INT);
    $activate->execute();
    $rez = $activate->rowCount();
    return $rez;
}
function unesiNovoPitanjeAnketa($pitanje){
    global $connection;
    $upit = "INSERT INTO survey (pitanje, active) VALUES (:pitanje, 0)";
    $prepare  = $connection->prepare($upit);
    $prepare->bindParam(":pitanje", $pitanje, PDO::PARAM_STR);
    $prepare->execute();
    $rez = $prepare->rowCount();
    return $rez;
}
function unesiNoveOdgovoreAnketa($id_survey, $odgovor){
    global $connection;
    $upit = "INSERT INTO survey_odgovori (odgovor, id_survey) VALUES (:odgovor, :id)";
    $prepare  = $connection->prepare($upit);
    $prepare->bindParam(":odgovor", $odgovor, PDO::PARAM_STR);
    $prepare->bindParam(":id", $id_survey, PDO::PARAM_INT);
    $prepare->execute();
    $rez = $prepare->rowCount();
    return $rez;
}
function deleteAnketa($id){
    global $connection;
    $upit = "DELETE FROM survey WHERE id = :id";
    $priprema = $connection->prepare($upit);
    $priprema->bindParam(":id", $id, PDO::PARAM_INT);
    $priprema->execute();
    $rez = $priprema->rowCount();
    return $rez;
}
?>
