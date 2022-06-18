<?php
include_once 'static/head.php';
include_once 'config/connection.php';
include_once 'models/functions.php';
include_once 'models/masterAdminContent.php';
if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
    $dohvati = dohvatiAnketu();
    foreach ($dohvati as $pod){
        var_dump($pod);
    }
}
?>
  <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse show h-100" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left h-100">
              <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                <li class="d-flex justify-content-center align-items-center text-danger font-weight-bold">Hello, <?=$_SESSION['korisnik']->imePrezime?>!</li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="admin/theme-assets/images/backgrounds/02.jpg">
      <div class="navbar-header d-flex align-items-center">
          <img class="brand-logo ml-1 mt-1" alt="Chameleon admin logo" src="img/logo.png"/>
          <a class="nav-link close-navbar ml-3 mt-1"><i class="ft-x-circle"></i></a>
      </div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a href="index.php"><i class="ft-arrow-left"></i><span class="menu-title" data-i18n="">Back to website</span></a>
            </li>
            <li class="nav-item" id="allPosts">
                <a><i class="ft-file-text"></i><span class="menu-title" data-i18n="">Manage posts</span></a>
            </li>
            <li class="nav-item" id="allUsers">
                <a><i class="ft-users"></i><span class="menu-title" data-i18n="">Manage users</span></a>
            </li>
            <li class="nav-item" id="messages">
                <a><i class="ft-message-square"></i><span class="menu-title" data-i18n="">Manage messages</span></a>
            </li>
            <li class="nav-item" id="newsletterShow">
                <a><i class="ft-home"></i><span class="menu-title" data-i18n="">Manage newsletters</span></a>
            </li>
            <li class="nav-item" id="categoriesShow">
                <a><i class="ft-inbox"></i><span class="menu-title" data-i18n="">Manage categories</span></a>
            </li>
            <li class="nav-item" id="manageSurvey">
                <a><i class="ft-file-text"></i><span class="menu-title" data-i18n="">Manage surveys</span></a>
            </li>
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>

    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
<!-- Chart -->
<!-- eCommerce statistic -->
<!--/ eCommerce statistic -->

<!-- Statistics -->
<div class="row match-height mt-5 mb-xl-5 mb-0">
    <div class="col-xl-4 col-lg-12">
        <div class="card pl-2">
            <div class="card-content">
                <div class="card-body p-0 py-2">
                    <h4 class="card-title m-0"><i class="ft-paperclip"></i> Recent posts</h4>
                </div>
                <ul id="recentPosts" style="list-style-type: none">
                    <?php foreach ($postovi as $post):?>
                    <li><a href="blog-details.php?id=<?=$post->id?>"> <?= substr_replace($post->naslov, '...', 50)?></a> </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="ft-user-plus"></i> Recent registered users</h4>

            </div>
            <div class="card-content">
                <div id="recent-buyers" class="media-list">
                    <?php foreach ($korisniciPoslednji as $korisnik):?>
                    <div class="my-1">
                        <span class="d-inline ml-2">#<?=$korisnik->id?></span>
                        <h6 class="d-inline"><?=$korisnik->imePrezime?></h6>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="ft-bar-chart-2"></i> Survey statistics</h4>

                </div>
                <div class="card-content pl-2 pb-2">
                    <div id="recent-buyers" class="media-list">
                        <?php if(!empty($dohvati)):?>
                            <p class="d-inline">Survey question: </p><?=$dohvati[0]->pitanje?>
                            <?php foreach ($dohvati as $podatak):?>
                            <p><?=$podatak->procenat?> % answered: <?=$podatak->odgovor?></p>
                            <?php endforeach;?>
                        <?php else:?>
                            <p>There is no survey data.</p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
</div>
          <div class="row">
              <div class="col d-flex justify-content-start align-items-center">
                  <button type="button" class="dgm addPost btn btn-dark mr-3">Add a new post</button>
                  <button type="button" class="dgm addCat btn btn-dark mr-3">Add new category</button>
                  <button type="button" class="dgm addSurvey btn btn-dark">Add new survey</button>
              </div>

          </div>
          <div class="row mt-xl-5 mb-0">
                <div class="col-12" id="adminContent">
                    <?php if (isset($_SESSION['surrErr'])){ echo $_SESSION['surrErr']; unset($_SESSION['surrErr']);}?>
                    <?php if(isset($_SESSION['unosNoSurvey'])):?>
                        <p class="my-1 alert-danger alert"><?=$_SESSION['unosNoSurvey']?></p>
                    <?php endif; unset($_SESSION['unosNoSurvey'])?>
                    <?php if(isset($_SESSION['unosSurvey'])):?>
                        <p class="my-1 alert-success alert"><?=$_SESSION['unosSurvey']?></p>
                    <?php endif; unset($_SESSION['unosSurvey'])?>
                        <?php if(isset($_SESSION['katErr'])):?>
                    <p class="my-1 alert-danger alert" id="catErr"><?=$_SESSION['katErr']?></p>
                    <?php endif; unset($_SESSION['katErr'])?>
                    <?php if(isset($_SESSION['katSucces'])):?>
                        <?=$_SESSION['katSucces']; unset($_SESSION['katSucces'])?>
                    <?php endif;?>
                    <?php if(isset($_SESSION['errType'])):?>
                        <p class="alert alert-danger"><?=$_SESSION['errType']?></p>
                        <?php unset($_SESSION['errType']); endif;?>
                    <?php if(isset($_SESSION['errSize'])):?>
                        <p class="alert alert-danger"><?=$_SESSION['errSize']?></p>
                        <?php unset($_SESSION['errSize']); endif;?>
                </div>
          </div>
      </div>
    </div>

<!--/ Statistics -->
    <!-- ////////////////////////////////////////////////////////////////////////////-->
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

    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">2021  &copy; Copyright <a class="text-bold-800 grey darken-2" href="https://themeselection.com" target="_blank">ThemeSelection</a></span>
        <ul class="list-inline float-md-right d-block d-md-inline-blockd-none d-lg-block mb-0">
          <li class="list-inline-item"> By: Adam Nikolic 101/19</li>
        </ul>
      </div>
    </footer>


    <script src="admin/theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="admin/theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
    <script src="admin/theme-assets/js/core/app-lite.js" type="text/javascript"></script>
    <script src="js/my_main.js" type="text/javascript"></script>
  </body>
</html>