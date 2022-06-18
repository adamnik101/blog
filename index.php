<?php
    include_once "config/connection.php";
    include_once "models/functions.php";
    include_once "static/head.php";
    include_once "static/preloader.php";
    include_once "static/header.php";
    $limit = 3;
    $postovi = dohvatiPostove($limit, 0);
    $poKomentarima = dohvatiPostovePoBrojuKomentara($limit, 0);
?>



    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero__text">
                        <div class="hero__text__title">
                            <h2>Car lovers community</h2>
                            <span>We are sure you will find what you're looking for</span>
                        </div>
                        <a href="#" class="primary-btn"><img src="img/wheel.png" alt=""> Over 6000+ posts</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <span>Our Blog</span>
                        <h2>Latest News Updates</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php  foreach ($postovi as $post):?>
                <?php $date = new DateTime($post->vremeKreiranja); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="latest__blog__item">
                        <div class="latest__blog__item__pic set-bg" data-setbg="img/<?=$post->slika?>">
                            <ul>
                                <li>By <?=$post->imePrezime?></li>
                                <li><?=$date->format('d M, Y')?></li>
                                <li>Comment (<?=brojKomentara($post->id_post)?>)</li>
                            </ul>
                        </div>
                        <span class="badge badge-light"><?=ucfirst($post->naziv_kategorije)?></span>
                        <div class="latest__blog__item__text pt-2">
                            <a href="blog-details.php?id=<?=$post->id_post?>"><h5><?=$post->naslov?></h5></a>
                            <p><?=substr_replace($post->tekst, '...', 180);?></p>
                            <a href="blog-details.php?id=<?=$post->id_post?>">View More <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </section>
    <section class="latest spad pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <span>Check out</span>
                        <h2>Hot topics</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php  foreach ($poKomentarima as $kom):?>
                    <?php $date = new DateTime($kom->vremeKreiranja); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="latest__blog__item">
                            <div class="latest__blog__item__pic set-bg" data-setbg="img/<?=$kom->slika?>">
                                <ul>
                                    <li>By <?=$kom->imePrezime?></li>
                                    <li><?=$date->format('d M, Y')?></li>
                                    <li>Comment (<?=brojKomentara($kom->id_post)?>)</li>
                                </ul>
                            </div>
                            <span class="badge badge-light"><?=$kom->naziv_kategorije?></span>
                            <div class="latest__blog__item__text pt-2">
                                <a href="blog-details.php?id=<?=$kom->id_post?>"><h5><?=$kom->naslov?></h5></a>
                                <p><?=substr_replace($kom->tekst, '...', 180);?></p>
                                <a href="blog-details.php?id=<?=$kom->id_post?>">View More <i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

<?php
    include_once "static/footer.php";
?>