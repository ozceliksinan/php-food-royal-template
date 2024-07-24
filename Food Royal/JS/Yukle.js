function SayfaYukle(htmlName) {

    loadAddressParameters();

    checkUrlLanguage(htmlName);

}

var loadParamArr = [];

function loadAddressParameters() {

    if (location.search.indexOf("?") == 0) {
        var paramArrRaw = location.search.split('?')[1];

        var paramArr = paramArrRaw.split('&');

        for (var i = 0; i < paramArr.length; i++) {
            if (paramArr[i].indexOf("targetTag") == 0) {
                loadParamArr.push([]);

                var targetArr = paramArr[i].split('!');

                for (var j = 0; j < targetArr.length; j++) {
                    loadParamArr[i].push(targetArr[j]);
                }

            }

        }
    }
}

function checkUrlLanguage(htmlName) {

    //standart dil seçiliyor
    var lang = "1"; //!!!!!!!!!!!!!

    if (location.pathname.indexOf(rootFolder + "/lang-en/") == 0) {

        lang = "2";

    }

    var postData = "call=setLanguage&Langid=" + lang;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Yukle.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            getPageElements(htmlName);

        } //readystate ok
    }; //onreadychange

}

function getPageElements(htmlName) {

    var xmlhttp = new XMLHttpRequest();
    var postData = "call=idList&pageName=" + htmlName;

    xmlhttp.open("POST", xhrConnectionPath + "Yukle.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var response = xmlhttp.responseText.replace(/\r\n/g, "").trim();

            if (response.trim().indexOf(",") != 0) {
                alert("xhr error " + response);
                return;
            }

            loadElements(response);

        } //readystate ok
    }; //onreadychange

}

function loadElements(response) {

    var elements = response.trim().slice(1).split(",");

    for (var i = 0; i < elements.length; i++) {
        (function (index, elementArray) {

            var loadParam = "";

            //if (elements[i].id == "")
            //    continue;

            //if (elements[i].id[0] == "_")
            //    continue;

            var element = document.getElementById(elementArray[index]);

            if (element == null)
                return; //sayfada eleman bulunamadı hatası verilecek

            var htmlid = element.id;
            var tagName = element.tagName;
            var tagType = element.dataset.tagtype;
            var isModule = false;

            if (tagType == "module")
                isModule = true;

            if (loadParamArr.length > 0) {
                for (var k = 0; k < loadParamArr.length; k++) {
                    if (loadParamArr[k][0].indexOf("targetTag") == 0) {
                        if (loadParamArr[k][0].replace("targetTag=", "") == htmlid) {
                            for (var l = 0; l < loadParamArr[k].length; l++) {
                                loadParam = loadParam + "!" + loadParamArr[k][l];
                            }

                            loadParam = loadParam.slice(1);
                        }
                    }
                }

            }

            var postData = "Htmlid=" + htmlid + "&loadParam=" + loadParam;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", xhrConnectionPath + "Yukle.php", true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(postData);

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    var response = xmlhttp.responseText.replace(/\r\n/g, "").trim();

                    responseComplete(tagName, element, response, isModule);

                } //readystate ok
            }; //onreadychange

        })(i, elements); //closure

    } //elements for

}

function responseComplete(tagName, element, response, isModule) {

    if (response.substr(0, 7) === "*error*") {
        alert(response);
        return;
    }

    //if (response.trim() == "")
    //    alert("path:"+xhrConnectionPath);

    //eğer modülse içerdiği jsnin de dom'a eklenmesi gerekiyor.
    if (isModule) {

        var moduleType = response.substr(0, response.indexOf("_"));
        response = response.slice(response.indexOf("_") + 1);
        element.innerHTML = response;

        loadModuleScript(moduleType);

        //i++;

        //continue;
        return;
    }

    if (tagName == "DIV" || tagName == "SECTION" || tagName == "P" || tagName == "LABEL" || tagName == "SPAN" ||
        tagName == "H1" || tagName == "H2" || tagName == "H3") {

        element.innerHTML = response;

    }

    if (tagName == "TEXTAREA") {

        element.placeholder = response;

    }

    if (tagName == "INPUT") {

        if (element.type == "button")
            element.value = response;
        else
            element.placeholder = response;

    }

    if (tagName == "IMG") {
        var responseArr = response.split('|');

        element.src = "img/" + responseArr[0];

        if (responseArr[1] != null)
            if (responseArr[1].length > 0) {

                var func = responseArr[1];
                element.onclick = function () {
                    eval(func);
                };

            }

    }

}

function TagYukle(elementid, loadParam, callback) {

    var element = document.getElementById(elementid);

    if (element == null) {
        alert("eleman alınamadı!");
        return;
    }

    var htmlid = element.id;
    var tagName = element.tagName;
    //var tagType = element.type;
    var isModule = false;

    if (htmlid.indexOf("_module") > 0) {
        htmlid = htmlid.replace("_module", "");
        isModule = true;
    }

    if (htmlid.indexOf("_generic") > 0) {
        htmlid = htmlid.replace("_generic", "");
    }

    if (htmlid.indexOf("_subpage") > 0) {
        htmlid = htmlid.replace("_subpage", "");
    }
    if (htmlid.indexOf("_list") > 0) {
        htmlid = htmlid.replace("_list", "");
    }

    var postData = "Htmlid=" + htmlid + "&loadParam=" + loadParam;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Yukle.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var response = xmlhttp.responseText.replace(/\r\n/g, "").trim();

            if (response.substr(0, 7) === "*error*") {
                alert(xmlhttp.responseText);
                return;
            }

            loadTagContent(element, tagName, response, isModule);
            if (callback != null)
                callback();

        } //readystate ok
    }; //onreadychange

}

function loadTagContent(element, tagName, response, isModule) {

    //eğer modülse içerdiği jsnin de dom'a eklenmesi gerekiyor.
    if (isModule) {

        var moduleType = response.substr(0, response.indexOf("_"));
        response = response.slice(response.indexOf("_") + 1);
        element.innerHTML = response;

        loadModuleScript(moduleType);

    }

    if (tagName == "DIV" || tagName == "SECTION" || tagName == "P" || tagName == "LABEL" || tagName == "SPAN" ||
        tagName == "H1" || tagName == "H2" || tagName == "H3" || tagName == "TEXTAREA")
        element.innerHTML = response;

    if (tagName == "INPUT" || tagName == "TEXTAREA")
        element.placeholder = response;

}

function loadModuleScript(moduleType) {

    var headID = document.getElementsByTagName("head")[0];
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = '..' + rootFolder + '/JS/' + moduleType + '.js';
    headID.appendChild(newScript);
}

function setLanguage(langid) {

    var postData = "call=setLanguage&Langid=" + langid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Yukle.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var search = location.search;
    var locPath = location.pathname;

    locPath = locPath.replace(rootFolder, "");

    //standart harici diğer diller temizleniyor
    locPath = locPath.replace("/lang-tr/", "/"); //!!!!!!!!!!!!!

    if (langid === "1") {

        if (locPath.indexOf("/lang-en/") >= 0) {
            locPath = locPath.replace("/lang-en/", "/");
        }

    } else if (langid === "2") {

        if (locPath.indexOf("/lang-en/") == -1) {
            locPath = "/lang-en" + locPath;
        }
    }

    location.pathname = rootFolder + locPath; // + search; search eklenince htaccess rewrite rule bozuluyordu

}