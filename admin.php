<?php
include_once "config/connection.php";
include_once "models/functions.php";
include_once "static/head.php";
include_once "static/preloader.php";
include_once "static/header.php";
include_once "models/masterAdminContent.php";
?>
<!-- Breadcrumb End -->
<section class="hero spad set-bg" data-setbg="img/hero-bg.jpg" style="background-position: 50% 15%">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="hero__text">
                    <div class="hero__text__title">
                        <h2>Admin panel</h2>
                    </div>
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
            <div class="col-12">
                    <div class="mb-5">
                        <h5 class="font-weight-bold">Welcome, <?= $korisnik->imePrezime?></h5>
                    </div>
                    <ul class="d-flex justify-content-start align-items-center flex-row">
                        <li class="m-3"><button type="button" name="allUsers" id="allUsers">All users</button> </li>
                        <li class="my-3 mr-3"><button type="button" name="allPosts" id="allPosts">All posts</button></li>
                        <li class="my-3"><button type="button" name="manageSurvey" id="manageSurvers">Manage surveys</button></li>
                    </ul>
            </div>
            <div class="col-12">
                                <div id="adminContent" class="table-responsive my-5">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" id="porukaED">

                            </div>
                        </div>
            </div>
</section>
<!-- Blog Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="messageAdmin" tabindex="-1" aria-labelledby="messageAdmin" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageAdminLabel">Server says</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
<!-- Search End -->
<?php
include_once "static/footer.php";
?>