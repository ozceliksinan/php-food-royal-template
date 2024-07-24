<?php
    session_start();
    include 'PHP/Meta.php';
    $page='mas-fasulye';
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

    <link rel="stylesheet" type="text/css" href="../CSS/mas-fasulye.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/mas-fasulye_m.css" media="screen and (max-width: 50rem)" />

    <link rel="stylesheet" type="text/css" href="../CSS/footer.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/footer_m.css" media="screen and (max-width: 50rem)" />

    <script type="text/javascript" src="../JS/Genel.js"></script>
    <script type="text/javascript" src="../JS/Yukle.js"></script>
    <script type="text/javascript" src="../JS/Kaydet.js"></script>
    <script type="text/javascript" src="../JS/Custom.js"></script>
       <script type="text/javascript" src="../JS/LazyLoadImgs.js"></script>

     <link rel="icon" type="image/png" href="../img/favicon16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="../img/favicon32.png" sizes="32x32" />


</head>
<body onload="SayfaYukle('mas-fasulye');
setMobile(window.innerWidth,false);
lazyLoadImgs();
setOzellikImgs();
anaUrunYukle('26');
startShiftInterval();
setSayfa('urun');" >

<!--<?php getHeadlines($page); ?>-->

<section id="mas-fasulye_header" data-tagtype="subpage" class="secHeader"></section>


<section class="secSlider">

    <div class="divSliderContainer">



        <div class="divLang">
            <div onclick="setLanguage(1);"><span>TR</span></div>
            <div onclick="setLanguage(2);"><span>EN</span></div>
        </div>

        <div class="divRoyal"><img data-src="../img/logo_royal.png"></div>

        <div class="divSliderImgs">
            <div class="divUrunSideImg"><img data-src="../img/urun_fasulye_mas_side.png"></div>
            <div class="divUrunImg"><img data-src="../img/product.png"></div>
        </div>

        <div class="divSliderContent">
            <div class="divTexts">
                <div class="divText">
                    <span id="mas-fasulye_baslik1"></span>
                    <p id="mas-fasulye_text1"></p>
                </div>
                <div class="divText">
                    <span id="mas-fasulye_baslik2"></span>
                    <p id="mas-fasulye_text2"></p>
                </div>
            </div>

            <div class="divSloganlar">
                <div class="divSloganUst">
                   <img data-osrc="../img/urun_ozellik_glutensiz">
                   <img data-osrc="../img/urun_ozellik_protein">
                   <img data-osrc="../img/urun_ozellik_lif">
                </div>
                <div class="divSloganAlt">
                    <img data-osrc="../img/urun_ozellik_glisemik2">
                    <img data-osrc="../img/urun_ozellik_antioksidan2">
                </div>

            </div>
        </div>

    </div>
</section>

<section class="secOzellikler">
    <div class="divOzellikler">

        <div class="divOzellik1"><span id="mas-fasulye_tabloBaslik"></span></div>
            <div class="divOzellik2">
                <div class="divOzellikRow"><span id="mas-fasulye_row1_1"></span><span id="mas-fasulye_row1_2"></span></div>
                <div class="divOzellikRow"><span id="mas-fasulye_row2_1"></span><span id="mas-fasulye_row2_2"></span></div>
                <div class="divOzellikRow"><span id="mas-fasulye_row3_1"></span><span id="mas-fasulye_row3_2"></span></div>
            </div>
            <div class="divOzellik3">
                <div class="divOzellikRow"><span id="mas-fasulye_row4_1"></span><span id="mas-fasulye_row4_2"></span></div>
                <div class="divOzellikRow"><span id="mas-fasulye_row5_1"></span><span id="mas-fasulye_row5_2"></span></div>
                <div class="divOzellikRow"><span id="mas-fasulye_row6_1"></span><span id="mas-fasulye_row6_2"></span></div>

            </div>
            <div class="divOzellik4">
               <div class="divOzellikRow"><span id="mas-fasulye_row7_1"></span><span id="mas-fasulye_row7_2"></span></div>
                <div class="divOzellikRow"><span id="mas-fasulye_row8_1"></span><span id="mas-fasulye_row8_2"></span></div>
            </div>

        </div>

</section>

<section class="secTarihce">

    <div class="divTarihce">
        <span id="mas-fasulye_spTarihBaslik"></span>
        <p id="mas-fasulye_pTarihce"></p>
    </div>

</section>

<section class="secTarif">


    <div class="divTarifSlogan"><span id="mas-fasulye_tarifSlogan"></span></div>
    <div class="divTarifBaslik"><img data-src="../img/masFasulyeBaslikBack.png"><span id="mas-fasulye_tarifBaslik"></span></div>

    <div class="divTarif">

        <div class="divTarifTexts">
            <div class="divTarifText">
                <span id="mas-fasulye_malzemeBaslik"></span>
                <p id="mas-fasulye_malzemeText"></p>
            </div>
            <div class="divTarifText">
                <span id="mas-fasulye_yapilisBaslik"></span>
                <p id="mas-fasulye_yapilisText"></p>
            </div>
        </div>
        <div class="divTarifImg"><img data-src="../img/masFasulyeTarif.jpg"></div>
    </div>


</section>
<section class="secVideo">
    <p id="mas-fasulye_videoSlogan"></p>
    <div class="divVideo" id="mas-fasulye_videoembedded">
    </div>
</section>

<section class="secUrunler">

     <div class="divUrunContainer">
        <div class="divUrunArrow prev" onclick="anaUrunPrev();"><img src="../img/prev.png"></div>
        <div class="divUrunWrapper"><div id="_urunler" class="divUrunler" style="left:0;"></div></div>
        <div class="divUrunArrow next" onclick="anaUrunNext();"><img src="../img/next.png"></div>
    </div>

    <div class="divRaf"><img data-src="../img/urunler_raf.png"></div>


</section>

<section class="secDiger">
     <div class="divDigerLink">
        <img data-src="../img/urunler_digerBack.jpg">
        <p id="mas-fasulye_digerText"></p>
        <div class="divDigerBtn">
            <img data-src="../img/digerBtnBack.png">
            <a href="#" target="_blank"><span id="mas-fasulye_digerBtn"></span></a>
        </div>
    </div>
</section>

<section id="mas-fasulye_footer" data-tagtype="subpage" class="secFooter"></section>


</body>
</html>