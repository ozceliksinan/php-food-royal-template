var imgCount = 5;
var imgPointer = 0;
var imgArray;
var divThumbs;

loadSliders();

function loadSliders() {
    var sliders = document.getElementsByClassName("divSliderThumbed");

    if (sliders.length == 0) {
        var int = setTimeout(function () {
            loadSliders();
            clearInterval(int);
        }, 500);

        return;
    }

    for (var i = 0; i < sliders.length; i++) {
        getImageArray(sliders[i].id.slice(1).replace("_divSliderThumbed", ""));
    }

}

function getImageArray(sliderid) {
    var postData = "call=getSliderThumbedArray&Sliderid=" + sliderid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "SliderThumbed.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");
    response = response.replace(/\n/g, "");

    if (response.trim() == "")
        imgArray = [""];
    else {
        imgArray = response.trim().slice(1).split(",");
    }

    loadThumbs(sliderid);
}

function loadThumbs(sliderid) {

    if (document.getElementById("_" + sliderid + "_divSliderThumbs") == null) {
        var int = setTimeout(function () {
            loadThumbs(sliderid);
            clearInterval(int);
        }, 500);

        return;
    }

    //var divThumbs = document.getElementById("_" + sliderid + "_divSliderThumbs").children;
    var divThumbs = document.getElementById("_" + sliderid + "_divSliderThumbs");

    var counter = imgCount;

    if (imgArray.length < imgCount)
        counter = imgArray.length;

    for (var i = 0; i < counter; i++) {
        //divThumbs[i].src = imgArray[i];

        var img = document.createElement("img");

        img.addEventListener("click", function () {
            LoadImg(sliderid, this);
        });

        img.src = imgArray[i];
        divThumbs.appendChild(img);
    }

    LoadImg(sliderid, divThumbs.children[0]);

}

function LoadImg(sliderid, thumb) {

    var images = document.getElementById("_" + sliderid + "_divSlthBigImgs").children;

    var imageIndex = 0;

    if (images[1].style.zIndex == 1)
        imageIndex = 1;

    for (var i = 0; i < images.length; i++) {
        images[i].classList.add('imgTrans');
        images[i].style.zIndex = 1;
    }

    images[imageIndex].src = thumb.src;
    images[imageIndex].classList.remove('imgTrans');
    images[imageIndex].style.zIndex = 0;

    var thumbs = document.getElementById("_" + sliderid + "_divSliderThumbs").children;

    for (var i = 0; i < thumbs.length; i++) {
        thumbs[i].style.opacity = 1;
    }

    thumb.style.opacity = 0.3;

}

function nextImg(sliderid) {

    if (imgArray.length < imgCount)
        return;

    if (imgArray.length - imgPointer <= imgCount)
        return;

    imgPointer++;

    var divThumbs = document.getElementById("_" + sliderid + "_divSliderThumbs");

    var thumbs = divThumbs.children;

    while (thumbs.length > 0) {
        divThumbs.removeChild(thumbs[0]);
    }

    for (var i = 0; i < imgCount; i++) {

        var img = document.createElement("img");

        img.addEventListener("click", function () {
            LoadImg(sliderid, this);
        });

        img.src = imgArray[i + imgPointer];
        divThumbs.appendChild(img);

    }

}

function prevImg(sliderid) {

    if (imgArray.length < imgCount)
        return;

    if (imgPointer <= 0)
        return;

    imgPointer--;

    var divThumbs = document.getElementById("_" + sliderid + "_divSliderThumbs");

    var thumbs = divThumbs.children;

    while (thumbs.length > 0) {
        divThumbs.removeChild(thumbs[0]);
    }

    for (var i = 0; i < imgCount; i++) {

        var img = document.createElement("img");

        img.addEventListener("click", function () {
            LoadImg(sliderid, this);
        });

        img.src = imgArray[i + imgPointer];
        divThumbs.appendChild(img);

    }

}