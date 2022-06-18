<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
include_once "static/preloader.php";
include_once "static/header.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $postDetails = getPostData($id);
    if($postDetails->rowCount() == 1){
        $post = $postDetails->fetch();
        $komentari = dohvatiKomentare($post->id_post);
        $date = new DateTime($post->datum);
    }
    else{
        header("Location: error404.php");
    }
}
else{
    header("Location: error404.php");
}
?>

    <!-- Blog Details Hero Begin -->
    <section class="blog-details-hero spad set-bg" style="background-image: url('img/autor.jpg')">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10">
                    <div class="blog__details__hero__text">
                        <span class="label"><?= $post->naziv_kat;?></span>
                        <h2><?= stripslashes($post->naslov); ?></h2>
                        <ul>
                            <li><span>By <?=stripslashes($post->imePrezime)?></span></li>
                            <li><i class="fa fa-calendar-o"></i> <span><?= $date->format('d M, Y')?></span></li>
                            <li><i class="fa fa-edit"></i> <span><?=brojKomentara($post->id_post)?> Comments</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="img/<?=$post->slika?>" alt="blog_img_<?=$post->id?>">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="blog__details__text">
                        <p><?=stripslashes(nl2br($post->tekst))?></p>
                    </div>
                    <div class="blog__details__share">
                        <a href="#" class="blog__details__share__item">
                            <i class="fa fa-facebook"></i>
                            <span>Share</span>
                        </a>
                        <a href="#" class="blog__details__share__item twitter">
                            <i class="fa fa-twitter"></i>
                            <span>Share</span>
                        </a>
                        <a href="#" class="blog__details__share__item google">
                            <i class="fa fa-google"></i>
                            <span>Share</span>
                        </a>
                        <a href="#" class="blog__details__share__item linkedin">
                            <i class="fa fa-linkedin"></i>
                            <span>Share</span>
                        </a>
                    </div>
                    <div class="blog__details__author">
                        <div class="blog__details__author__text">
                            <h5>Author: <?= stripslashes($post->imePrezime)?></h5>
                        </div>
                    </div>
                    <div class="blog__details__btns">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__details__comment">
                        <h4>Comments:</h4>
                        <?php if($brojKomentara = brojKomentara($post->id_post)):?>
                        <?php foreach ($komentari as $komentar):?>
                            <?php  $date = new DateTime($komentar->datum);?>
                        <div class="blog__details__comment__item">
                            <div class="blog__details__comment__item__text">
                                <?php if(isset($_SESSION['korisnik'])):?>
                                    <?php if(!($_SESSION['korisnik']->id_kor == $komentar->id_kor)):?>
                                        <h6><?=stripslashes($komentar->imePrezime)?></h6>
                                    <?php else:?>
                                        <h6>You</h6>
                                    <?php endif;?>
                                <?php else:?>
                                    <h6><?=stripslashes($komentar->imePrezime)?></h6>
                                <?php endif;?>
                                <p><?=stripslashes(nl2br($komentar->tekst, false))?></p>
                                <span><?=$date->format('d M, Y')?></span>
                                <?php if(isset($_SESSION['korisnik'])):?>
                                    <?php if($_SESSION['korisnik']->id_uloga == 1):?>
                                        <button type="button" class="mr-auto d-inline delComm" data-comment="<?= $komentar->id?>"><i class="fa fa-trash-o"></i></button>
                                    <?php endif; ?>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php else:?>
                            <div class="my-3">
                                <h3>No comments yet.</h3>
                            </div>

                        <?php endif;?>
                    </div>
                    <?php if(isset($_SESSION['korisnik'])):?>
                    <div class="blog__details__comment__form">
                        <h4>Leave A Comment</h4>
                        <form action="#">
                            <div class="input-desc">
                                <textarea placeholder="Comment here" name="comment" id="message" data-id="<?= $post->id_post?>"></textarea>
                                <span id="msgComment"></span>
                            </div>
                            <button type="button" class="site-btn" id="sendComment">Submit Now</button>
                        </form>
                    </div>
                    <?php else:?>
                        <div class="my-3">
                            <h4>You must login to comment.</h4>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="messageAdmin" tabindex="-1" aria-labelledby="messageAdmin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageAdminLabel">Server says</h5>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Blog Details Section End -->

<?php
    include_once 'static/footer.php';
?>