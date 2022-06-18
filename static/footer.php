<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="footer__contact">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?php
                    if(isset($_SESSION['korisnik'])): $isAnswered = proveriAnketuKorisnika($_SESSION['korisnik']->id_kor); ?>
                        <?php if(!$isAnswered && $_SESSION['korisnik']):?>
                            <?php $dohvatiFormuZaAnketu = dohvatiFormuZaAnketu();?>
                        <div class="survey">
                            <form action="models/obradaAnketa.php" method="post" class="form-check">
                                <h5 class="font-weight-bold mb-2 text-white"><?=$dohvatiFormuZaAnketu[0]->pitanje?></h5>
                                <?php foreach ($dohvatiFormuZaAnketu as $podaci):?>
                                <div class="d-block"> <input type="radio" value="<?=$podaci->id_odgovor?>" required name="odgovor" id="odg<?=$podaci->id_odgovor?>"> <label for="odg<?=$podaci->id_odgovor?>" class="text-white"><?=$podaci->odgovor?></label></div>
                                <?php endforeach;?>
                                <button type="submit" value="<?=$podaci->id_survey?>" name="sent" class="custom-control btn btn-secondary">Answer survey!</button>
                            </form>
                        </div>
                        <?php elseif (isset($_SESSION['anketaUspeh'])):?>
                            <p class="alert alert-success"><?=explode(' ', $_SESSION['korisnik']->imePrezime)[0].', '.$_SESSION['anketaUspeh']; unset($_SESSION['anketaUspeh'])?></p>
                            <?php elseif (isset($_SESSION['anketaErr'])):?>
                                <p class="alert alert-danger"><?=explode(' ', $_SESSION['korisnik']->imePrezime)[0].', '.$_SESSION['anketaErr']?></p>
                        <?php unset($_SESSION['anketaErr']);endif;?>
                    <?php else:?>
                        <h3 class="text-white">Contact us now!</h3>
                    <?php endif;?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__contact__option">
                        <a href="contact.php"><button type="button" class="form-control btn-danger">Contact administrator</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="footer__about">
                    <div>
                        <ul>
                            <li><a href="docs.pdf">Documentation</a>
                            </li>
                            <li><a href="autor.php" class="ml-2">Author</a>
                            </li>
                            <li><a href="sitemap.xml" class="ml-2">Sitemap</a>
                            </li>
                        </ul>
                    </div>
                    <p>Any questions? Let us know in store at 625 Gloria Union, California, United Stated or call us
                        on (+1) 96 123 8888</p>
                    <div class="footer__social">
                        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="google"><i class="fa fa-google"></i></a>
                        <a href="#" class="skype"><i class="fa fa-skype"></i></a>
                    </div>
                    <div class="footer__brand">
                        <h5>Links</h5>
                        <ul class="d-flex w-100 flex-row justify-content-start align-items-center">
                            <?php
                            for ($i = 0; $i < count($menu); $i++){
                                if(isset($korisnik)){
                                    if(($korisnik->id_uloga != 1 && strpos($menu[$i]->naziv, 'admin') !== false) || strpos($menu[$i]->naziv, 'login') !== false || strpos($menu[$i]->naziv, 'reg') !== false){
                                        continue;
                                    }
                                    echo  '<li class="mr-1 mr-sm-3"><a href='.$menu[$i]->putanja.' class="text-uppercase">'.$menu[$i]->naziv.'</a></li>';
                                }
                                else {
                                    if (strpos($menu[$i]->naziv, 'admin') !== false || strpos($menu[$i]->naziv, 'profile') !== false || strpos($menu[$i]->naziv, 'create') !== false || strpos($menu[$i]->naziv, 'out') !== false) {
                                        continue;
                                    }
                                    echo '<li class="mr-1 mr-sm-3"><a href=' . $menu[$i]->putanja . '>' . $menu[$i]->naziv . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        <div class="footer__copyright__text">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
        </div>
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="js/my_main.js" type="text/javascript"></script>
</body>

</html>
