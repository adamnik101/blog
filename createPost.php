<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
include_once "static/preloader.php";
include_once "static/header.php";
if(!isset($_SESSION['korisnik'])){
    header('Location: error404.php');
}
?>



    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero spad set-bg" data-setbg="img/hero-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero__text">
                        <div class="hero__text__title">
                            <h2>Create a post</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->


    <!-- Latest Blog Section Begin -->
    <section class="latest spad p-0 my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h3 class="font-weight-bold">What makes a quality blog post?</h3>
                    <ul style="list-style-type: none" class="tips">
                        <li>Does you title explain what your post will be about and encourage visitors to read on?</li>
                        <li>Do you break up text into short paragraphs to make it easier to read?</li>
                        <li class="font-weight-bold">Press enter if you want to end a paragraph</li>
                        <li>Have you proofread your work before publishing?</li>
                        <li>Check your spelling, grammar, punctuation, spacing etc.</li>
                        <li>Do you include questions at the end of your post to encourage visitiors to leave a comment?</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <form onSubmit="return dodajPost();" enctype="multipart/form-data" action="models/obradaPost.php" method="post">
                        <label for="naslovPost" class="">Title:</label>
                        <input type="text" id="naslovPost" class="form-control" name="naslovPost"/>
                        <label for="postCat" class="">Category</label>
                        <select name="postCat" id="postCat" class="form-control">
                            <option value="0">Choose</option>
                            <?php
                            $data = getAllData('kategorija_post');
                            foreach ($data as $option):
                                ?>
                                <option value="<?= $option->id?>"><?=ucfirst($option->naziv)?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="slika">Image:</label>
                        <input type="file" class="form-control-file" id="slika" size="50" name="slika"/>
                        <label for="tekstPost">Post content:</label>
                        <textarea rows="20" name="tekstPost" id="tekstPost" class="form-control"></textarea>
                        <input type="submit" name="posaljiPost" value="Create a post">
                    </form>
                    <div id="ispisGreske">
                        <?php if(isset($_SESSION['errType'])):?>
                            <p class="danger alert alert-danger"><?=$_SESSION['errType']?></p>
                            <?php unset($_SESSION['errType']); endif;?>
                        <?php if(isset($_SESSION['errSize'])):?>
                            <p class="danger alert alert-danger"><?=$_SESSION['errSize']?></p>
                            <?php unset($_SESSION['errSize']); endif;?>
                    </div>
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
    <!-- Latest Blog Section End -->

<?php
include_once "static/footer.php";
?>