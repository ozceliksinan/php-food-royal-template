var idArr = document.getElementsByName("moduleid");
var paramArr = document.getElementsByName("moduleParam");

var postData = "Sliderid=" + idArr[0].value; //ilk eleman alınıyor, birden fazla eleman için düzenle

var xmlhttp = new XMLHttpRequest();
xmlhttp.open("POST", xhrConnectionPath + "Slider1.php", false);
xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlhttp.send(postData);

var response = xmlhttp.responseText.replace(/\r\n/g, "");
var response = xmlhttp.responseText.replace(/\n/g, "");

var backgroundArray;
if (response.trim() == "")
    backgroundArray = ["gray"];
else {
    backgroundArray = response.trim().slice(1).split(",");
}

var index = 0;
var percent = 0;

var divs0 = document.getElementsByClassName("Div0");
divs0[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";

var parameter = paramArr[0].value;
var timer = parameter.replace("timer=", "");
setInterval(function () {
    selectNav(index + 1);
}, timer);

function selectNav(indx) {

    nextSlidePercent(indx);

    var divSelected = document.getElementsByClassName("NavSelected");

    if (divSelected == null)
        return;

    divSelected[0].classList.remove("NavSelected");

    var divSelectedNew = document.getElementsByClassName("Nav" + index);

    if (divSelectedNew == null)
        return;

    divSelectedNew[0].classList.add("NavSelected");

}

function nextSlidePercent(indx) {

    if (percent > 1)
        return;

    var divs0 = document.getElementsByClassName("Div0");
    var divs1 = document.getElementsByClassName("Div1");
    var divs2 = document.getElementsByClassName("Div2");

    divs0[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";

    index = indx;

    if (index == backgroundArray.length)
        index = 0;

    if (divs1[0].style.left == "0px" || divs1[0].style.left == "0" || divs1[0].style.left == "") {

        divs2[0].style.left = "100%";
        divs2[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";
        percent = 100;
        setPercentDecrease(divs2[0]);

        divs1[0].style.left = "100%";

    } else {

        divs1[0].style.left = "100%";
        divs1[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";
        percent = 100;
        setPercentDecrease(divs1[0]);

        divs2[0].style.left = "100%";
    }

}

function prevSlidePercent() {

    if (percent < -1)
        return;

    var divs0 = document.getElementsByClassName("Div0");
    var divs1 = document.getElementsByClassName("Div1");
    var divs2 = document.getElementsByClassName("Div2");

    divs0[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";

    if (index == 0)
        index = backgroundArray.length;

    index--;

    if (divs1[0].style.left == "0px" || divs1[0].style.left == "0" || divs1[0].style.left == "") {

        divs2[0].style.left = "-100%";
        divs2[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";
        percent = -100;
        setPercentIncrease(divs2[0]);

        divs1[0].style.left = "-100%";

    } else {

        divs1[0].style.left = "-100%";
        divs1[0].style.backgroundImage = "url('" + backgroundArray[index] + "')";
        percent = -100;
        setPercentIncrease(divs1[0]);

        divs2[0].style.left = "-100%";
    }

}

var lastUpdate = Date.now();
var incProgress = false;
var decProgress = false;

function setPercentDecrease(div) {

    if (percent == -1 || incProgress) {
        decProgress = false;
        return;
    }

    decProgress = true;

    var now = Date.now();
    var delta = now - lastUpdate;
    lastUpdate = now;

    div.style.left = percent + "%";
    percent--;

    setTimeout(function () {
        setPercentDecrease(div);
    }, 1 / delta);
    //setPercentDecrease(div);

}

function setPercentIncrease(div) {

    if (percent == 1 || decProgress) {
        incProgress = false;
        return;
    }

    incProgress = true;

    var now = Date.now();
    var delta = now - lastUpdate;
    lastUpdate = now;

    div.style.left = percent + "%";
    percent++;

    setTimeout(function () {
        setPercentIncrease(div);
    }, 1 / delta);
    //setPercentIncrease(div);

}