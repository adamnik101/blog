<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
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
                            <h2>Author</h2>
                        </div>
                        <a href="https://adamnik101.github.io/adamportfolio/" target="_blank" class="primary-btn"> Portfolio</a>
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
                <div class="col-lg-8">
                    <div class="section-title text-left">
                        <span>About me</span>
                        <h2>Adam Nikolic 101/19</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <p class="autorTekst">Hi. I'm a web developer from Požega, Serbia. Right now I'm studying Internet Technologies at Information and Communication Technologies College in Belgrade and I'm pursuing career in Web programming.</p>
                </div>
                <div class="col-lg-4">
                    <img src="img/autor.jpg" class="img-fluid" alt="autor">
                </div>
            </div>
        </div>
    </section>
<?php
include_once "static/footer.php";
?>