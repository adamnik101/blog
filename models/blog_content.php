<?php
if(strpos($_SERVER['REQUEST_URI'], 'blog.php') == true) {
    $brojNajskorijihMAX = 4;
    $najskoriji = getLatestPosts($brojNajskorijihMAX);

    $limit = 6;
    $offset = 0;
    if (isset($_GET['page'])) {
        $offset = ($_GET['page'] - 1) * $limit;
    }

    $kategorije = getAllData('kategorija_post');
    if (isset($_GET['searchFilter'])) {
        global $connection;
        $cat = $_GET['category'];
        $upit = "SELECT p.id AS id_post, p.slika_src AS slika, p.naslov AS naslov, p.korisnik_id AS id_kor, p.tekst AS tekst, kat.naziv AS naziv_kategorije, p.datum AS vremeKreiranja, count(kom.id_post) AS komentar, k.imePrezime AS imePrezime FROM post p LEFT JOIN komentar kom ON p.id = kom.id_post LEFT JOIN korisnik k ON p.korisnik_id = k.id LEFT JOIN kategorija_post kat ON p.kategorija_id = kat.id WHERE p.kategorija_id = :kat GROUP BY p.id LIMIT :limit OFFSET :offset";
        $upit2 = "SELECT COUNT(*) AS brojPostova FROM post p LEFT JOIN kategorija_post kp ON p.kategorija_id = kp.id WHERE p.kategorija_id = :kat1";
        $priprema1 = $connection->prepare($upit2);
        $priprema1->bindParam(":kat1", $cat, PDO::PARAM_INT);
        $priprema1->execute();
        $ukupno = $priprema1->fetch();
        if (isset($_GET['category'])) {
            $priprema = $connection->prepare($upit);
            $priprema->bindParam(":kat", $cat, PDO::PARAM_INT);
            $priprema->bindParam(':offset', $offset, PDO::PARAM_INT);
            $priprema->bindParam(':offset', $offset, PDO::PARAM_INT);
            $priprema->bindParam(':limit', $limit, PDO::PARAM_INT);
            $priprema->execute();
            $rezultat = $priprema->rowCount();
            if ($rezultat >= 1) {
                $postovi = $priprema->fetchAll();
                $total = count($postovi);
                $brojStranica = ceil($ukupno->brojPostova / $limit);
            } else {
                $GLOBALS['results'] = ['msg' => 'Unfortunalety I could not find any posts matching your criteria.'];
            }
        }
    } else {
        $brojPostova = count(getAllData('post'));
        $brojStranica = ceil($brojPostova / $limit);
        $postovi = dohvatiPostove($limit, $offset);
    }
}
else{
    header("Location: ../error404.php");
}
?>