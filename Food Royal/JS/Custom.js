var last_known_width = 0;
var ticking = false;

window.addEventListener('resize', function (e) {

    last_known_width = window.innerWidth;
    if (!ticking) {
        window.requestAnimationFrame(function () {
            setMobile(last_known_width, true);
            ticking = false;
        });
    }

    ticking = true;

});

var isMobile = false;
var mobileWidth = 800; //50 rem, media query şartına göre değiştir
var sayfa = "";

function setMobile(width, resize) {

    if (window.innerWidth <= mobileWidth) {
        isMobile = true;
    } else {
        isMobile = false;
    }

    if (isMobile) {

        ana_urun_LeftAmount = 18;

    } else {
        ana_urun_LeftAmount = 10;
    }

    if (resize) {

        //pencere boyutu değişince bazen tekrar çalıştırmak gerekebiliyor

        anaUrunYukleAfter();

        setTimeout(function () {
            setMobile(0, false);
        }, 100);

    }
}

function setSayfa(sayfaAdi) {

    sayfa = sayfaAdi;

    //ürün menü eventleri

    if (typeof _divUrunMenu === 'undefined') {
        setTimeout(function () {
            setSayfa(sayfaAdi);
        }, 100);

        return;
    }

    _divUrunMenu.addEventListener("mouseenter", function () {

        hoverUrunMenu = true;
    });

    _divUrunMenu.addEventListener("mouseleave", function () {

        hoverUrunMenu = false;
        closeUrunMenu();
    });

}

var togglingMobileMenu = false;

function toggleMobileMenu() {

    if (togglingMobileMenu)
        return;

    togglingMobileMenu = true;

    var items = document.querySelectorAll(".divMobileMenuItem");

    if (_divMobileMenu.style.visibility == "hidden") {

        _divMobileMenu.style.visibility = "visible";

        for (var i = 0; i < items.length; i++) {
            items[i].style.height = "7.0em";
            items[i].style.borderBottom = "0.2em solid #730B3F";
        }

        setTimeout(function () {
            togglingMobileMenu = false;
        }, 200);

    } else {

        for (var i = 0; i < items.length; i++) {
            items[i].style.height = "0";
            items[i].style.borderBottom = "none";
        }

        setTimeout(function () {
            _divMobileMenu.style.visibility = "hidden";
            togglingMobileMenu = false;
        }, 200);

        //ürünler alt menüsü kapatılıyor
        var items = document.querySelectorAll(".divMobilUrun");
        closeMobilUrunMenu(items);
    }

}

var togglingMobileUrunMenu = false;

function toggleMobilUrunMenu() {

    if (togglingMobileUrunMenu)
        return;

    togglingMobileUrunMenu = true;

    var items = document.querySelectorAll(".divMobilUrun");

    if (items[0].style.height == "5em") {

        closeMobilUrunMenu(items);

    } else {

        // _divMobileMenu.style.visibility="visible";
        _divMobileMenu.children[2].style = "height: auto; border-bottom: 0.2em solid rgb(115, 11, 63);";

        for (var i = 0; i < items.length; i++) {
            items[i].style.height = "5em";
            //items[i].style.borderBottom="0.2em solid #FFEF81";
        }

        setTimeout(function () {
            togglingMobileUrunMenu = false;
        }, 200);

    }

}

function closeMobilUrunMenu(items) {

    for (var i = 0; i < items.length; i++) {
        items[i].style.height = "0";
        //items[i].style.borderBottom="none";
    }

    setTimeout(function () {
        //_divMobileMenu.style.visibility="hidden";
        togglingMobileUrunMenu = false;
    }, 200);

}

var togglingUrunMenu = false;
var hoverUrunMenu = false;

var closeUrunMenuVar;

function toggleUrunMenu() {

    if (togglingUrunMenu)
        return;

    togglingUrunMenu = true;

    if (_divUrunMenu.style.visibility == "hidden") {

        _divUrunMenu.style.visibility = "visible";
        _divUrunMenu.style.opacity = "1";

        setTimeout(function () {
            togglingUrunMenu = false;
        }, 200);

        clearTimeout(closeUrunMenuVar);

        closeUrunMenuVar = setTimeout(function () {
            closeUrunMenu();
        }, 3000);

    } else {
        closeUrunMenu();
    }

}

function closeUrunMenu() {

    if (hoverUrunMenu == true)
        return;

    hoverUrunMenu = false;

    _divUrunMenu.style.opacity = "0";

    setTimeout(function () {
        _divUrunMenu.style.visibility = "hidden";
        togglingUrunMenu = false;

    }, 200);

}

function anaSosyalKapat() {

    var div = document.querySelector(".divHeaderSocial2");

    if (div === null) {

        setTimeout(function () {
            anaSosyalKapat();
        }, 200);

        return;
    }

    div.style.display = "none";
}

////ÜRÜNLER

function anaUrunYukle(urunid) {

    if (urunid == null)
        TagYukle("_urunler", "tagType=generic!referenceid=6", anaUrunYukleAfter);
    else
        TagYukle("_urunler", "tagType=generic!referenceid=6!exclude:" + urunid, anaUrunYukleAfter);

    //lazyLoadProducts();

}

function anaUrunYukleAfter() {

    var divs = document.querySelectorAll(".divUrunAna");

    for (var i = 0; i < divs.length; i++) {

        divs[i].style.left = (i * ana_urun_LeftAmount) + "em";

    }

}

function lazyLoadProductsIPTAL() { //bazen ürünler görünmüyordu iptal edildi

    if (lazyLoadProgress) {
        setTimeout(function () {
            lazyLoadProducts();
        }, 100);
        return;
    }

    lazyLoadImgs(_urunler);

}

var currentLeft = 0;
var ana_urun_LeftAmount = 0;
var shifting = false;
var intervalTime = 2500;
var shiftInterval;

function startShiftInterval() {

    clearInterval(shiftInterval);

    shiftInterval = setInterval(function () {
        anaUrunNext();
    }, intervalTime);

}

function anaUrunPrev() {

    if (shifting == true)
        return;

    shifting = true;
    clearInterval(shiftInterval);

    var clone = _urunler.lastChild.cloneNode(true);
    clone.style.left = "-" + ana_urun_LeftAmount + "em";

    _urunler.insertBefore(clone, _urunler.firstChild);

    anaUrunPrevAfter();

}

function anaUrunPrevAfter() {

    if (_urunler.firstChild.offsetHeight === 0) {

        window.requestAnimationFrame(anaUrunPrevAfter);
        return;
    }

    for (var i = 0; i < _urunler.children.length; i++) {

        var currentLeft = _urunler.children[i].style.left.replace("em", "").replace("px", "");
        currentLeft = parseInt(currentLeft);

        _urunler.children[i].style.left = (currentLeft + ana_urun_LeftAmount) + "em";

    }

    setTimeout(function () {

        _urunler.removeChild(_urunler.lastChild);

        shifting = false;
        shiftInterval = setInterval(function () {
            anaUrunNext();
        }, intervalTime);

    }, 300);
}

function anaUrunNext() {

    if (shifting == true)
        return;

    shifting = true;
    clearInterval(shiftInterval);

    var clone = _urunler.firstChild.cloneNode(true);
    clone.style.left = (ana_urun_LeftAmount * _urunler.children.length) + "em";

    _urunler.appendChild(clone);

    anaUrunNextAfter();

}

function anaUrunNextAfter() {

    if (_urunler.lastChild.offsetHeight === 0) {

        window.requestAnimationFrame(anaUrunNextAfter);
        return;
    }

    for (var i = 0; i < _urunler.children.length; i++) {

        var currentLeft = _urunler.children[i].style.left.replace("em", "").replace("px", "");
        currentLeft = parseInt(currentLeft);

        _urunler.children[i].style.left = (currentLeft - ana_urun_LeftAmount) + "em";

    }

    setTimeout(function () {

        _urunler.removeChild(_urunler.firstChild);

        shifting = false;
        shiftInterval = setInterval(function () {
            anaUrunNext();
        }, intervalTime);

    }, 300);

}

////ÜRÜNLER BİTTİ

////TARİF SLİDER

var currentSlideIndex = -1;
var slides = [];

var sliderInterval;
var sliderIntervalIsSet = false;
var sliderDuration = 5000;

function loadNextTarifSlide() {

    if (slides.length == 0)
        slides = document.querySelectorAll(".divTarifSlide");

    currentSlideIndex++;

    if (currentSlideIndex == slides.length)
        currentSlideIndex = 0;

    loadTarifSlider(currentSlideIndex);

}

function loadPrevTarifSlide() {

    if (slides.length == 0)
        slides = document.querySelectorAll(".divTarifSlide");

    currentSlideIndex--;

    if (currentSlideIndex == -1)
        currentSlideIndex = slides.length - 1;

    loadTarifSlider(currentSlideIndex);

}

function nextTarifSlideInterval() {

    if (sliderIntervalIsSet) {
        //alert("interval return");
        return;
    }

    sliderIntervalIsSet = true;

    sliderInterval = setInterval(function () {

        if (slides.length == 0)
            slides = document.querySelectorAll(".divTarifSlide");

        currentSlideIndex++;

        if (currentSlideIndex == slides.length)
            currentSlideIndex = 0;

        loadTarifSlider(currentSlideIndex);

    }, sliderDuration);

}

function loadTarifSlider(sliderNo) {

    clearInterval(sliderInterval);
    sliderIntervalIsSet = false;

    if (slides.length == 0)
        slides = document.querySelectorAll(".divTarifSlide");

    for (var i = 0; i < slides.length; i++) {

        if (i < sliderNo) {
            slides[i].style.left = "-100%";
        } else if (i == sliderNo) {
            slides[i].style.left = "0";
        } else if (i > sliderNo) {
            slides[i].style.left = "100%";
        }

    }

    var selected = document.querySelector(".dotSelected");

    if (selected != null) {
        selected.classList.remove("dotSelected");
    }

    var dots = document.querySelectorAll(".divSliderDot");
    dots[sliderNo].classList.add("dotSelected");

    nextTarifSlideInterval();

}

function sliderTurnSİL() {

    //return;

    if (sliderIntervalIsSet) {
        //alert("interval return");
        return;
    }

    sliderIntervalIsSet = true;

    sliderInterval = setInterval(function () {

        var sliderDivs = document.querySelectorAll(".divSlider");
        var btnDivs = document.querySelectorAll(".divSliderBtn");

        for (let i = 0; i < sliderDivs.length; i++) {

            let img = sliderDivs[i].querySelector("img");

            if (img.style.opacity === "1") {

                sliderDivs[i].style.zIndex = "0";

                img.style.opacity = "0";

                let btn = btnDivs[i];
                btn.classList.remove("btnSelected");

                let index = i + 1;

                if (i === sliderDivs.length - 1)
                    index = 0;

                sliderDivs[index].style.zIndex = "1";

                let imgNew = sliderDivs[index].querySelector("img");
                imgNew.style.opacity = "1";

                let btnNew = btnDivs[index];
                btnNew.classList.add("btnSelected");

                break;
            }

        }

    }, sliderDuration);

}

function detectswipe(el, func) {
    swipe_det = new Object();
    swipe_det.sX = 0;
    swipe_det.sY = 0;
    swipe_det.eX = 0;
    swipe_det.eY = 0;
    var min_x = 30; //min x swipe for horizontal swipe
    var max_x = 30; //max x difference for vertical swipe
    var min_y = 50; //min y swipe for vertical swipe
    var max_y = 60; //max y difference for horizontal swipe
    var direc = "";
    ele = document.getElementById(el);
    ele.addEventListener('touchstart', function (e) {
        var t = e.touches[0];
        swipe_det.sX = t.screenX;
        swipe_det.sY = t.screenY;
    }, false);
    ele.addEventListener('touchmove', function (e) {
        e.preventDefault();
        var t = e.touches[0];
        swipe_det.eX = t.screenX;
        swipe_det.eY = t.screenY;
    }, false);
    ele.addEventListener('touchend', function (e) {
        //horizontal detection
        if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y) && (swipe_det.eX > 0)))) {
            if (swipe_det.eX > swipe_det.sX) direc = "r";
            else direc = "l";
        }
        //vertical detection
        else if ((((swipe_det.eY - min_y > swipe_det.sY) || (swipe_det.eY + min_y < swipe_det.sY)) && ((swipe_det.eX < swipe_det.sX + max_x) && (swipe_det.sX > swipe_det.eX - max_x) && (swipe_det.eY > 0)))) {
            if (swipe_det.eY > swipe_det.sY) direc = "d";
            else direc = "u";
        }

        if (direc != "") {
            if (typeof func == 'function') func(el, direc);
        }
        direc = "";
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
    }, false);
}

function loadSwipeDirection(el, d) {

    //alert("you swiped on element with id '"+el+"' to "+d+" direction");

    if (d === "r") loadPrevTarifSlide();
    if (d === "l") loadNextTarifSlide();

}

////TARİF SLİDER BİTTİ

var dilEki = ".png";
if (location.pathname.indexOf(rootFolder + "/lang-en/") == 0) {

    dilEki = "_en.png"; //resim değişimi için resimlerin sonuna eklenecek

}

function setOzellikImgs() {

    var imgArr = document.querySelectorAll("img");

    for (let i = 0; i < imgArr.length; i++) {

        if (imgArr[i].hasAttribute("data-osrc")) {

            imgArr[i].src = imgArr[i].getAttribute("data-osrc") + dilEki;

        }

    }

}

function tarifleriYukle() {

    TagYukle("_tarifler", "tagType=generic!referenceid=7", loadTarifVideos);

}

function loadTarifVideos() {

    var videos = document.querySelectorAll(".divTarifVideo");

    for (let i = 0; i < videos.length; i++) {

        let pLink = videos[i].querySelector("p");

        if (pLink.innerHTML != "")
            videos[i].innerHTML =
                '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' + pLink.innerHTML + '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';

    }

    ozellikleriTemizle();
}

function ozellikleriTemizle() {

    var ozellikler = document.querySelectorAll(".divOzellik");

    for (let i = 0; i < ozellikler.length; i++) {

        let span = ozellikler[i].querySelector("span");
        if (span.innerHTML === "") {

            ozellikler[i].style.visibility = "hidden";

        }

    }

}

function uruneGit(page) {

    window.location = page + ".php";

}

////KURUMSAL

function kurumsalContentYukle(index) {

    let contents = document.querySelectorAll(".divContent");

    for (let i = 0; i < contents.length; i++) {

        contents[i].style.maxHeight = "0em";

    }

    let items = document.querySelectorAll(".divKurumsalMenuItem");
    let selected = document.querySelector(".divKurumsalMenuItemSelected");

    if (selected != null)
        selected.classList.remove("divKurumsalMenuItemSelected");

    items[index].classList.add("divKurumsalMenuItemSelected");

    if (index == 1) {

        TagYukle("_basidabiz", "tagType=generic!referenceid=9", kampanyaVideoYukle);

    }
    if (index == 3) { //reklam kampanyası

        TagYukle("_kampanyalar", "tagType=generic!referenceid=8", kampanyaVideoYukle);

    }
    if (index == 4) { //basın bülteni

        TagYukle("_bultenler", "tagType=generic!referenceid=10!notext");

    }

    if (index == 5) { //katalog

        TagYukle("_kataloglar", "tagType=generic!referenceid=11", kataloglariYukle);

    }

    setTimeout(function () {

        let divContent = document.getElementById("_content" + index);

        divContent.style.maxHeight = "360em";

    }, 300);

}

function kampanyaVideoYukle() {

    var videos = document.querySelectorAll(".divVideoLink");

    for (let i = 0; i < videos.length; i++) {

        let spLink = videos[i].querySelector("span");

        if (spLink.innerHTML != "") {

            let divKampanya = videos[i].parentNode;
            let divImg = divKampanya.querySelector(".divKampanyaImg");
            let img = divImg.querySelector("img");
            img.src = "http://img.youtube.com/vi/" + spLink.innerHTML + "/0.jpg";

        }

    }

}

function kampanyaFull(divKampanya) {

    let divVideo = divKampanya.querySelector(".divVideoLink");

    let spLink = divVideo.querySelector("span");

    if (spLink.innerHTML != "") {
        expandFullscreen(spLink.innerHTML, "video", divKampanya.id);
    } else {
        let divImg = divKampanya.querySelector(".divKampanyaImg");
        let img = divImg.querySelector("img");

        expandFullscreen(img.src, "img", divKampanya.id);
    }

}

function expandFullscreen(source, type, divId) {

    var newDiv2 = document.createElement('div');
    newDiv2.id = "divOverlay";
    newDiv2.classList.add("black_overlay");
    newDiv2.classList.add("black_overlayAni");
    newDiv2.addEventListener("click", function () {
        expandPicClose();
    });

    var divLeft = document.createElement('div');
    divLeft.classList.add("divLeftArrow");
    var divLeftSpan = document.createElement('i');
    divLeftSpan.classList.add("leftArrow");
    divLeftSpan.addEventListener("click", function (e) {
        loadPrevSrc(e, divId);
    });
    divLeft.appendChild(divLeftSpan);

    var divRight = document.createElement('div');
    divRight.classList.add("divRightArrow");
    var divRightSpan = document.createElement('i');
    divRightSpan.classList.add("rightArrow");
    divRightSpan.addEventListener("click", function (e) {
        loadNextSrc(e, divId);
    });
    divRight.appendChild(divRightSpan);

    newDiv2.appendChild(divLeft);

    if (type == "img") {

        var newImg = document.createElement('img');
        newImg.id = "bigImg";
        newImg.src = source;

        if (newImg.width > newImg.height)
            newImg.className = "imgFullWide";
        else
            newImg.className = "imgFullHigh";

        newDiv2.appendChild(newImg);
    }

    if (type == "video") {

        var newFrame = document.createElement('iframe');
        newFrame.src = 'https://www.youtube.com/embed/' + source + '?rel=0&amp;showinfo=0;autoplay=1';
        newFrame.allowFullscreen = true;
        newFrame.className = "iFrameVideo";

        newDiv2.appendChild(newFrame);

        /*if(!isMobile) {
            divLeft.style.top = "35%";
            divRight.style.top = "35%";
        }*/

    }

    newDiv2.appendChild(divRight);

    document.body.appendChild(newDiv2);

}

function expandPicClose() {

    var div = document.getElementById("divOverlay");

    div.parentNode.removeChild(div);

}

function loadPrevSrc(e, divId) {

    let currentDiv = document.getElementById(divId);

    if (currentDiv.previousElementSibling == null)
        return;

    let prevDiv = currentDiv.previousElementSibling;

    expandPicClose();
    kampanyaFull(prevDiv);

    e.stopPropagation();

}

function loadNextSrc(e, divId) {

    let currentDiv = document.getElementById(divId);

    if (currentDiv.nextElementSibling == null)
        return;

    let nextDiv = currentDiv.nextElementSibling;

    expandPicClose();
    kampanyaFull(nextDiv);

    e.stopPropagation();

}

function bultenFull(bultenDiv) {

    var divOverlay = document.getElementById("divOverlay");

    if (divOverlay != null)
        return;

    ////
    var newDiv2 = document.createElement('div');
    newDiv2.id = "divOverlay";
    newDiv2.classList.add("black_overlay");
    newDiv2.classList.add("black_overlayAni");
    //newDiv2.addEventListener("click", function () { expandPicClose(); });

    var divBultenContent = document.createElement('div');
    divBultenContent.classList.add("divBultenFullContainer");

    ////

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getGenerics");
    data.append("referenceid", "10");
    data.append("loadParam", "idlist=" + bultenDiv.id.slice(1));

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Yukle.php", false);
    xhr.send(data);

    let response = xhr.responseText.trim();

    String.prototype.replaceAll = function (search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };

    response = response.replaceAll("divBulten", "divBultenFull");

    divBultenContent.innerHTML = response;

    ////

    var divClose = document.createElement('div');
    divClose.classList.add("divBultenClose");
    divClose.innerHTML = "X";
    divClose.addEventListener("click", function () {
        expandPicClose();
    });

    divBultenContent.appendChild(divClose);
    newDiv2.appendChild(divBultenContent);
    document.body.appendChild(newDiv2);

}

function kataloglariYukle() {

    let divKatalogs = _kataloglar.querySelectorAll(".divKatalog");

    for (let i = 0; i < divKatalogs.length; i++) {

        let spLink = divKatalogs[i].querySelector(".divKatalogBaslik span:last-of-type");

        if (spLink.innerHTML == "") {
            continue;
        }

        let aLink = document.createElement("a");
        aLink.href = "../files/" + spLink.innerHTML;
        aLink.target = "_blank";

        //var divLinkNew=divLinks[i].cloneNode(true);

        //aLink.appendChild(divLinkNew);
        divKatalogs[i].appendChild(aLink);

    }

}

////KURUMSAL BİTTİ