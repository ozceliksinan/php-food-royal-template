var xhrConnectionPath = "";

//var rootFolder="/beta";
var rootFolder = "";

//if(window.location.host=="localhost")
xhrConnectionPath = "http://" + window.location.host + rootFolder + "/PHP/";
//else if(window.location.host.indexOf("www")==0)
//else

function toggleDropdown(div) {
    //var parentDiv = span.parentNode.parentNode;
    var uls = div.getElementsByTagName("ul");

    if (uls[0].style.visibility == "hidden" || uls[0].style.visibility == "") {
        uls[0].style.visibility = "visible";
    } else {
        uls[0].style.visibility = "hidden";
    }
}