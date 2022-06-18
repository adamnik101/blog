<!-- Offcanvas Menu Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__logo">
        <a href="index.php"><img src="img/logo.png" alt=""></a>
    </div>
    <div id="mobile-menu-wrap"></div>
    <ul class="offcanvas__widget__add">
        <li><i class="fa fa-envelope-o"></i> Info.colorlib@gmail.com</li>
    </ul>
    <div class="offcanvas__phone__num">
        <i class="fa fa-phone"></i>
        <span>(+12) 345 678 910</span>
    </div>
    <div class="offcanvas__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-google"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
</div>
<!-- Offcanvas Menu End -->

<!-- Header Section Begin -->
<header class="header">

    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="index.php"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="header__nav">
                    <nav class="header__menu">
                        <ul>
                            <?php
                                $menu = getAllData('meni');
                                global $korisnik;
                                for ($i = 0; $i < count($menu); $i++){
                                    if(isset($korisnik)){
                                        if(($korisnik->id_uloga != 1 && strpos($menu[$i]->naziv, 'admin') !== false) || strpos($menu[$i]->naziv, 'login') !== false || strpos($menu[$i]->naziv, 'reg') !== false){
                                            continue;
                                        }
                                        echo  '<li><a href='.$menu[$i]->putanja.' class="text-uppercase">'.$menu[$i]->naziv.'</a></li>';
                                    }
                                    else {
                                        if (strpos($menu[$i]->naziv, 'admin') !== false || strpos($menu[$i]->naziv, 'profile') !== false || strpos($menu[$i]->naziv, 'create') !== false || strpos($menu[$i]->naziv, 'out') !== false) {
                                            continue;
                                        }
                                        echo '<li><a href=' . $menu[$i]->putanja . '>' . $menu[$i]->naziv . '</a></li>';
                                    }
                                }
                                ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <span class="fa fa-bars"></span>
        </div>
    </div>
</header>
