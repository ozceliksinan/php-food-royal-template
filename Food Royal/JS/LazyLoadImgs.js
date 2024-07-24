var imgArr = [];
var srcArr = [];
var errArr = [];
var lazyLoadProgress = false;

//resimlerde src yerine data-src yazılacak
function lazyLoadImgs(container) {

    if (lazyLoadProgress === true)
        return;

    lazyLoadProgress = true;

    //console.log("lazy girişi, imgArr:"+imgArr.length);

    imgArr = [];
    srcArr = [];
    errArr = [];

    console.log("Lazy Loading");

    let imgNodes;

    if (container != null)
        imgNodes = container.querySelectorAll("img");
    else {

        imgNodes = document.querySelectorAll("img");

        if (imgNodes.length < 1) {
            setTimeout(function () {
                lazyLoadImgs();
            }, 100);
            return;
        }
    }

    for (let i = 0; i < imgNodes.length; i++) {

        if (imgNodes[i].getAttribute('data-src') != null) {

            imgArr.push(imgNodes[i]);
        }

    }

    for (let i = 0; i < imgArr.length; i++) {

        srcArr.push(imgArr[i].getAttribute('data-src'));

        imgArr[i].onload = function () {
            processImgQueue(i);
        };
        imgArr[i].onerror = function () {
            addImgError(i);
        };

    }

    if (srcArr[0] != null)
        imgArr[0].src = srcArr[0];
    else {
        if (srcArr.length > 0)
            processImgQueue(1);
    }

}

function processImgQueue(index) {

    //console.log("img index:"+index);

    if (index < imgArr.length - 1) {

        if (srcArr[index + 1] != null)
            imgArr[index + 1].src = srcArr[index + 1];

        /* else {  queryselectorall tüm resimleri karışık getiriyordu; öyle yapınca processque resimleri sırayla işlemiyordu. dataseti olanları imgArray'e almaya başladım, sırayla işlem yapıldığı için buraya gerek kalmadı  buraya gerek kalmadı
            //resimler içinde dataseti olan bir sonraki resime gidiyoruz
            for (let i = index+1; i < srcArr.length; i++) {
  
                 if (srcArr[i] != null)
                     imgArr[i].src = srcArr[i];
  
                 else if(i < srcArr.length-1) {
                     processImgErrors();
                 }
            }
        }*/

    } else if (index == imgArr.length - 1) {

        processImgErrors();

    }

}

function addImgError(index) {

    if (imgArr[index].src.slice(-1) == "/") //resim src zaten boşsa errArr içine eklenmiyor
        return;

    errArr.push(index);

    console.log("error loading:" + imgArr[index].src); //!!!!!!!!!!!!!!!!!!!!!!!!!!

}

function processImgErrors() {

    //console.log("errArr length:"+errArr.length);//!!!!!!!!!!!!!!!!!!!!!!!!!!

    if (errArr.length == 0) {

        lazyLoadProgress = false;
        return;
    }

    for (let i = 0; i < errArr.length; i++) {

        let imgIndex = errArr[i];

        imgArr[imgIndex].onload = function () {
            advanceImgErrors(imgIndex);
        };
        imgArr[imgIndex].onerror = function () { };

    }

    imgArr[errArr[0]].src = srcArr[errArr[0]];
}

var prevErrIndex;

function advanceImgErrors(index) {

    if (prevErrIndex == index) //önceki resim yine geldiyse yüklenemiyor demektir, hata sistemi duruyor
        return;

    prevErrIndex = index;

    removeErr(index);

    if (errArr.length > 0)
        imgArr[errArr[0]].src = srcArr[errArr[0]];
    else
        lazyLoadProgress = false;

}

function removeErr(imgIndex) {

    let errIndex = errArr.indexOf(imgIndex);

    if (errIndex > -1)
        errArr.splice(errIndex, 1);

}