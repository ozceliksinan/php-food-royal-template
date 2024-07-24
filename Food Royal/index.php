<?php
    session_start();
    include 'PHP/Meta.php';
    $page='index';
?>
<!DOCTYPE html>
<html lang=<?php getLangCode(); ?> >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php getPageTitle($page); ?></title>
    <meta name="description" content=<?php getDescription($page); ?>>
    <meta name="keywords" content=<?php getKeywords($page); ?>>
    
    <meta name="author" content="Sinan Özçelik">
    <meta name="Sinan Özçelik" content="Sinan Özçelik - Software Developer"/>
    <meta name="publisher" content="VS 2022" />
    
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@sinanozcelik">
    <meta name="twitter:title" content="Twitter Card Kullanımı">
    <meta name="twitter:description" content="Sinan Özçelik - Software Developer">
    <meta name="twitter:creator" content="@sinanozcelik">
    <meta name="twitter:domain" content="https://www.sinanozcelik.com/">
    
    <meta property="og:locale" content="tr_TR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Sinan Özçelik - Software Developer" />
    <meta property="og:description" content="Sinan Özçelik - Software Developer" />
    <meta property="og:url" content="https://www.sinanozcelik.com/" />
    <meta property="og:site_name" content="Sinan Özçelik" />

    <link rel="stylesheet" type="text/css" href="../CSS/genel.css"/>

    <link rel="stylesheet" type="text/css" href="../CSS/header.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/header_m.css" media="screen and (max-width: 50rem)" />

    <link rel="stylesheet" type="text/css" href="../CSS/index.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/index_m.css" media="screen and (max-width: 50rem)" />

    <link rel="stylesheet" type="text/css" href="../CSS/footer.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/footer_m.css" media="screen and (max-width: 50rem)" />

    <script type="text/javascript" src="../JS/Genel.js"></script>
    <script type="text/javascript" src="../JS/Yukle.js"></script>
    <script type="text/javascript" src="../JS/Kaydet.js"></script>
    <script type="text/javascript" src="../JS/Custom.js"></script>
    <script type="text/javascript" src="../JS/LazyLoadImgs.js"></script>

     <link rel="icon" type="image/png" href="img/favicon16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="img/favicon32.png" sizes="32x32" />

</head>
<body onload="SayfaYukle('index');
setMobile(window.innerWidth,false);
lazyLoadImgs();
anaUrunYukle();
startShiftInterval();
loadTarifSlider(0);
anaSosyalKapat();
setSayfa('index');
detectswipe('_tarifSlider',loadSwipeDirection);" >

<!--<?php getHeadlines($page); ?>-->

<section id="index_header" data-tagtype="subpage" class="secHeader"></section>


<section class="secSlider">

    <div class="divSliderContainer">

        <div class="divBlank">&nbsp;</div>

        <div class="divSocial">
            <div><a href="https://www.facebook.com/" target="_blank"><img data-src="img/icon_face.png"></a></div>
            <div><a href="https://www.instagram.com/" target="_blank"><img data-src="img/icon_insta.png"></a></div>
            <div><a href="https://www.youtube.com/user/" target="_blank"><img data-src="img/icon_you.png"></a></div>
        </div>
        <div class="divLang">
            <div onclick="setLanguage('1');"><span>TR</span></div>
            <div onclick="setLanguage('2');"><span>EN</span></div>
        </div>

        <div class="divRoyal"><img data-src="img/logo_royal.png"></div>

        <div class="divSliderImg"><img data-src="img/sliderFront.png"></div>
        <div class="divSlogan1"><span id="index_slogan1"></span></div>
        <div class="divSlogan2"><span id="index_slogan2"></span></div>

    </div>

</section>


<section class="secUrunler">



    <div class="divSliderTear">
        <img data-src="img/sliderTear.png">
    </div>

    <div class="divUrunSlogan"><p id="index_urunSlogan"></p></div>

    <div class="divUrunContainer">
        <div class="divUrunlerBack"><img data-src="img/urunlerBack.png"></div>
        <div class="divUrunArrow prev" onclick="anaUrunPrev();"><img data-src="img/prev.png"></div>
        <div class="divUrunWrapper"><div id="_urunler" class="divUrunler" style="left:0;"></div></div>
        <div class="divUrunArrow next" onclick="anaUrunNext();"><img data-src="img/next.png"></div>
    </div>


</section>

<section class="secTarif">

    <div class="divTarifRow">

        <div id="_tarifSlider" class="divTarifSlider">

        <div class="divSliderDots" >
            <div class="divSliderDot" onclick="loadTarifSlider(0);"></div>
            <div class="divSliderDot" onclick="loadTarifSlider(1);"></div>
            <div class="divSliderDot" onclick="loadTarifSlider(2);"></div>
            <div class="divSliderDot" onclick="loadTarifSlider(3);"></div>
        </div>


        <div class="divTarifSlide" >
            <div class="divTarifSliderBack"><img data-src="img/slider_tarif1.jpg"></div>
            <div class="divTarif1Text">
                <span id="index_sliderBaslik1"></span>
                <p id="index_sliderText1"></p>
            </div>
        </div>

            <div class="divTarifSlide slide2" >
                <div class="divTarifSliderBack"><img data-src="img/slider_tarif2.jpg"></div>
                <div class="divTarif2Text">
                    <span id="index_sliderBaslik2"></span>
                    <p id="index_sliderText2"></p>
                </div>
            </div>

            <div class="divTarifSlide slide3" >
                <div class="divTarifSliderBack"><img data-src="img/slider_tarif3.jpg"></div>
                <div class="divTarif3Text">
                    <span id="index_sliderBaslik3"></span>
                    <p id="index_sliderText3"></p>
                </div>
            </div>

            <div class="divTarifSlide slide4" >
                <div class="divTarifSliderBack"><img data-src="img/slider_tarif4.jpg"></div>
                <div class="divTarif4Text">
                    <span id="index_sliderBaslik4"></span>
                    <p id="index_sliderText4"></p>
                </div>
            </div>

        </div>

        <div class="divVideoTarif">
            <a href="tarifler.php">
                <div class="divTarifVideoBack"><img data-src="img/video_tarif.jpg"></div>
                <div class="divVideoText"><span id="index_videoText"></span></div>
            </a>
        </div>
    </div>

    <div class="divTarifLink">
        <img data-src="img/tarifBack.jpg">
        <span id="index_tarif1"></span>
        <a href="tarifler.php"><span id="index_tarifBtn"></span></a>
        <span id="index_tarif2"></span>

    </div>

    <div class="divDigerLink">
        <img data-src="img/digerBack.jpg">
        <p id="index_diger"></p>
        <div class="divDigerBtn">
            <img data-src="img/digerBtnBack.png">
            <a href="#" target="_blank"><span id="index_digerBtn"></span></a>
        </div>
    </div>


</section>

<section id="index_footer" data-tagtype="subpage" class="secFooter"></section>


</body>
</html>