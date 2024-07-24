<?php
    session_start();
    include 'PHP/Meta.php';
    $page='kurumsal';
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

    <link rel="stylesheet" type="text/css" href="../CSS/kurumsal.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/kurumsal_m.css" media="screen and (max-width: 50rem)" />

    <link rel="stylesheet" type="text/css" href="../CSS/footer.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/footer_m.css" media="screen and (max-width: 50rem)" />

    <script type="text/javascript" src="../JS/Genel.js"></script>
    <script type="text/javascript" src="../JS/Yukle.js"></script>
    <script type="text/javascript" src="../JS/Kaydet.js"></script>
    <script type="text/javascript" src="../JS/Custom.js"></script>
    <!--<script type="text/javascript" src="../JS/Scroll.js"></script>-->

     <link rel="icon" type="image/png" href="img/favicon16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="img/favicon32.png" sizes="32x32" />



</head>
<body onload="SayfaYukle('kurumsal');
setMobile(window.innerWidth,false);

setSayfa('kurumsal');
kurumsalContentYukle(0);

" >

<!--<?php getHeadlines($page); ?>-->

<section id="kurumsal_header" data-tagtype="subpage" class="secHeader"></section>




<section class="secUst">


    <div class="divUstContainer">

         <div class="divLang">
            <div onclick="setLanguage(1);"><span>TR</span></div>
            <div onclick="setLanguage(2);"><span>EN</span></div>
         </div>


        <div class="divBlank">&nbsp;</div>




        <div class="divRoyal"><img src="img/logo_royal.png"></div>

<!--        <div class="divSayfaBaslik"><span id="tarifler_sayfaBaslik"></span></div>-->


    </div>


    <div class="divTear"><img src="img/sliderTear.png"></div>

</section>

<section class="secKurumsal">


    <div class="divKurumsalMenu">
        <div class="divKurumsalMenuItem divKurumsalMenuItemSelected" onclick="kurumsalContentYukle('0');">
            <span id="kurumsal_spBaslik1"></span>
        </div>
         <div class="divKurumsalMenuItem" onclick="kurumsalContentYukle('1');">
            <span id="kurumsal_spBaslik2"></span>
        </div>
         <div class="divKurumsalMenuItem" onclick="kurumsalContentYukle('2');">
            <span id="kurumsal_spBaslik3"></span>
        </div>
         <div class="divKurumsalMenuItem" onclick="kurumsalContentYukle('3');">
            <span id="kurumsal_spBaslik4"></span>
        </div>
         <div class="divKurumsalMenuItem" onclick="kurumsalContentYukle('4');">
            <span id="kurumsal_spBaslik5"></span>
        </div>
         <div class="divKurumsalMenuItem" onclick="kurumsalContentYukle('5');">
            <span id="kurumsal_spBaslik6"></span>
        </div>
    </div>

    <div id="_container" class="divContainer">

        <div id="_content0" class="divContent">

            <div>&nbsp;</div>
            <div class="divBaslik"><span id="kurumsal_spHakkimizdaBaslik"></span></div>
            <div class="divText"><p id="kurumsal_HakkimizdaText"></p></div>

        </div>

        <div id="_content1" class="divContent">

            <div id="_basidabiz" class="divKampanyaContainer">

           

            </div>

        </div>


         <div id="_content2" class="divContent">

            <div>&nbsp;</div>
            <div class="divBaslik"><span id="kurumsal_spSosyalBaslik"></span></div>
            <div class="divText"><p id="kurumsal_pSosyalText"></p></div>

        </div>

        <div id="_content3" class="divContent">

            <div id="_kampanyalar" class="divKampanyaContainer">

            

            </div>

        </div>

         <div id="_content4" class="divContent">

            <div id="_bultenler" class="divKampanyaContainer">

           

            </div>

        </div>

         <div id="_content5" class="divContent">

            <div id="_kataloglar" class="divKampanyaContainer">
            </div>
         </div>

    </div>


</section>

<section id="kurumsal_footer" data-tagtype="subpage" class="secFooter"></section>



</body>
</html>