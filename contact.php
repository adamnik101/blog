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
                            <h2>Contact</h2>
                        </div>
                        <h4 class="text-white-50 font-weight-bold">Send a message to administrators</h4>
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
                <div class="col">
                    <h4 class="text-center">Fill in the form below</h4>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <?php if(isset($_SESSION['wow']) && $_SESSION['wow']== 1):?>
                    <p class="alert-success p-2">You have successfully sent a message!</p>
                    <?php unset($_SESSION['wow']);endif;?>
                    <form action="models/obradaPoruka.php" method="POST" onsubmit="return proveriPoruku()">
                        <div class="row">
                            <div class="col mb-4">
                                <input type="text"  id="fullname" class="form-control" name="nameContact" placeholder="Full name">
                                <?php echo (isset($_SESSION['nameErr'])) ? $_SESSION['nameErr'] : "";unset($_SESSION['nameErr']) ?>
                            </div>
                            <div class="col">
                                <input  id="mail" type="email" name="emailContact" class="form-control" placeholder="Email">
                                <?php echo (isset($_SESSION['mailErr'])) ? $_SESSION['mailErr'] : "";unset($_SESSION['mailErr']) ?>
                            </div>
                        </div>
                        <textarea name="messageContact" id="messContent" rows="10" class="form-control mt-4" placeholder="Your message"></textarea>
                        <?php echo (isset($_SESSION['messErr'])) ? $_SESSION['messErr'] : ""; unset($_SESSION['messErr'])?>
                        <input type="submit" name="sendMessageAdmin" id="sendMessageAdmin" class="form-control btn btn-danger mt-4" value="Send a message">
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php
include_once "static/footer.php";
?>