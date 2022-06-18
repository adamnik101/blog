<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
if(!isset($_SESSION['korisnik'])){
    header("Location: error404.php");
}else{
    global $korisnik;
    $date1 = new DateTime($korisnik->vremeKreiranja);
    $date2 = new DateTime('now');
    $razlika = $date1->diff($date2);
    $memberTime = $razlika->format('%d days, %m months and %y years');
    $limit = 6;
    $offset = 0;
    if(isset($_GET['user-page']) && isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
        $offset = ($_GET['user-page'] - 1) * $limit;
        if($offset < 0){
            header("Location: error404.php");
        }
    }
    $postovi = getUserPosts($korisnik->id_kor, $limit, $offset);
    $ukupanBrojPostova = getCountUserPosts($korisnik->id_kor)->brojPostova;
    $stranice = ceil($ukupanBrojPostova/$limit);
    $broj = 1;
}
include_once "static/preloader.php";
include_once "static/header.php";
?>



    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero__text">
                        <div class="hero__text__title">
                            <h2>My profile</h2>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Hero Section End -->
    <section class="spad">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div id="infoAcc">
                        <h2 class="mb-3">Account information:</h2>
                        <p><span>Full name:</span> <?= $korisnik->imePrezime?></p>
                        <p><span>Role:</span> <?= ucfirst($korisnik->uloga)?></p>
                        <p><span>Email:</span> <?= $korisnik->email?></p>
                        <p><span>User ID:</span> #<?= $korisnik->id_kor?></p>
                        <p><span>Member for:</span> <?= $memberTime?></p>
                        <p><span>Posts created:</span> <?= $ukupanBrojPostova?></p>
                    </div>
                    <div>
                        <h3 class="font-weight-bold text-center my-3">Your posts</h3>
                    </div>
                    <div id="allPostsUser">
                        <?php if(count($postovi)):?>
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Headline</th>
                                <th>Date created</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr></thead>

                            <?php foreach ($postovi as $post):?>
                                <tr>
                                    <td><?=$broj?></td>
                                    <td><a class="naslov" href="blog-details.php?id=<?=$post->id?>"><?= substr_replace($post->naslov, '...', 50)?></a></td>
                                    <td><?= $post->datum?></td>
                                    <td><button type="button" data-toggle="modal" data-target="#content" data-post="<?=$post->id?>" class="editPost btn btn-primary" >Edit</button></td>
                                    <td><button type="button" data-post="<?=$post->id?>" class="delPost btn btn-danger">Delete</button></td>
                                </tr>
                            <?php $broj++; endforeach;?>
                        <?php else:?>
                        <h5 class="text-center">Create posts to see them here.</h5>
                        <?php endif;?>

                        </table></div>
                        <div class="d-flex justify-content-center align-items-center">
                            <?php for ($i = 0; $i < $stranice; $i++):?>
                                <a href="profile.php?user-page=<?= $i + 1?>" class="m-1"><button type="button" class="btnPag"><?=$i + 1?></button></a>
                            <?php endfor;?>
                        </div>

                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col" id="adminContent">

                </div>
            </div>
        </div>
    </section>
        <div class="modal fade" id="messageAdmin" tabindex="-1" role="dialog" aria-labelledby="content" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contentHeader">Server says</h5>
                    </div>
                    <div class="modal-body" id="adminContent">

                    </div>
                </div>
            </div>
        </div>
<?php
include_once "static/footer.php";
?>