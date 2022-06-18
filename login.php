<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
include_once "static/preloader.php";
include_once "static/header.php";
if(isset($_SESSION['korisnik'])){
    header("Location: error404.php");
};
?>



    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero__text">
                        <div class="hero__text__title">
                            <h2>Login</h2>
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
                <div class="col d-flex justify-content-center align-items-center flex-column">
                    <form class="col-5">
                        <label for="emailLog">Email:</label>
                        <input type="text" name="emailLog" id="emailLog" class="text-input"/>
                        <label for="passwordLog">Password:</label>
                        <input type="password" name="passwordLog" id="passwordLog" class="text-input"/>
                        <input type="button" class="site-btn" id="login" value="Login"/>
                    </form>
                    <p id="msgLog" class="mt-2"></p>
                </div>
            </div>
        </div>
    </section>

<?php
include_once "static/footer.php";
?>