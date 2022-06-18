<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
include_once "static/preloader.php";
include_once "static/header.php";
include_once "models/blog_content.php";
?>
    <!-- Breadcrumb End -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero__text">
                        <div class="hero__text__title">
                            <h2>Blogs</h2>
                            <span>Take a deep dive into our posts</span>
                        </div>
                        <a href="#" class="primary-btn"><img src="img/wheel.png" alt=""> Over 6000+ posts</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Breadcrumb Begin -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <?php if (isset($GLOBALS['results'])):?>
                            <h5 class="my-3"><?=$GLOBALS['results']['msg']?></h5>
                        <?php endif;?>
                        <?php if(isset($postovi)):?>
                            <?php foreach ($postovi as $post):?>
                                <?php $datum = new DateTime($post->vremeKreiranja);?>
                                <div class="col-lg-6 col-md-6">
                                    <div class="latest__blog__item">
                                        <div class="latest__blog__item__pic set-bg" data-setbg="img/<?=$post->slika?>">
                                            <ul>
                                                <li>By <?= getUserCreator($post->id_kor)?></li>
                                                <li><?= $datum->format('M d, Y')?></li>
                                                <li>Comments (<?= brojKomentara($post->id_post)?>)</li>
                                            </ul>
                                        </div>
                                        <div class="latest__blog__item__text pt-2">
                                            <span class="badge badge-light"><?=ucfirst($post->naziv_kategorije)?></span>
                                            <a href="blog-details.php?id=<?=$post->id_post?>" class="d-block"><h5><?= $post->naslov?></h5></a>
                                            <p><?= substr_replace($post->tekst, "...", 180)?></p>
                                            <a href="<?='blog-details.php?id='.$post->id_post?>">View More <i class="fa fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <ul class="pagination__option d-flex flex-row" style="list-style: none">
                        <?php if(isset($brojStranica)):?>
                            <?php for ($i = 0; $i < $brojStranica; $i++):?>
                            <li class="mr-2">
                                <?php if(isset($_GET['category'])):?>
                                    <a href="blog.php?page=<?=$i+1?>&searchFilter=1&category=<?=$_GET['category']?>"><?= $i + 1?></a>
                                <?php else:?>
                                    <a href="blog.php?page=<?=$i+1?>"><?= $i + 1?></a>
                                    <?php endif;?>
                            </li>
                            <?php endfor;?>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-9">
                    <div class="blog__sidebar">
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="GET" class="blog__sidebar__search">
                            <label for="catSearch">Category:</label>
                            <select name="category" class="form-control" id="catSearch">
                                <option value="0">Choose</option>
                                <?php foreach ($kategorije as $kat): var_dump($kat);?>
                                    <?php if(isset($_GET['category']) && $kat->id == $_GET['category']):?>
                                        <option value="<?=$kat->id?>" selected><?=ucfirst($kat->naziv)?></option>
                                    <?php else:?>
                                        <option value="<?=$kat->id?>"><?=ucfirst($kat->naziv)?></option>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                            <button type="submit" class="my-3 d-block p-3" name="searchFilter" value="1"> Search posts</button>
                        </form>
                        <div class="blog__sidebar__feature">
                            <h4>Latest Posts</h4>
                            <?php foreach ($najskoriji as $post):?>
                                <?php $datum = new DateTime($post->datum);?>
                                <div class="blog__sidebar__feature__item">
                                    <h6><a href="blog-details.php?id=<?=$post->id?>"><?= $post->naslov?></a></h6>
                                    <ul>
                                        <li>By <?= getUserCreator($post->korisnik_id)?></li>
                                        <li><?= $datum->format('d M, Y');?></li>
                                    </ul>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="">
                            <h4>Newsletter</h4>
                            <p>Subscribe to our newsletter</p>
                            <form id="newsletter">
                                <input type="email" placeholder="Your email" class="form-control" name="newsletter" id="newsletterMail">
                                <span id="newsMess"></span>
                                <button type="submit" class="form-control btn btn-danger my-2">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="messageAdmin" tabindex="-1" aria-labelledby="messageAdmin" aria-hidden="true" style="z-index: 9999">
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
    <!-- Blog Section End -->

<?php
    include_once 'static/footer.php';
?>