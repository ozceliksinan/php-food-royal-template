function LoadSubpageManagement() {

    //setBackground(0);

    var postData = "call=GetSubpageManager";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");


    divContent.innerHTML = response;

    divPages.innerHTML = "";


    divSaveBtn.style.display = "none";
    //divSaveBtn.onclick=function(){ baseGrupKaydet(); };


    divApplyAll.style.display = "none";
    //divApplyAll.onclick=function(){ baseGrupTumuneUygulaConfirm(); };


    //tagEkleYukle();

    selectPanelButton(4);



}

function LoadSubpageList(subpageid) {

    var postData = "call=LoadSubpageList&Subpageid=" + subpageid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");
    var secContent = document.getElementById("divGenericList");
    secContent.innerHTML = response;
}

function AddSubpage() {

    var txt = document.getElementById("txtSubpageName");



    var postData = "call=AddSubpage&subpageName=" + txt.value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    if (response.trim() == "ok") {
        LoadSubpageManagement();
    }
    else {
        alert(response);
    }


}

function DeleteSubpage() {
    var select = document.getElementById("selSubpage");

    var postData = "call=DeleteSubpage&subpageid=" + select.value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    if (response.trim() == "ok") {
        LoadSubpageManagement();
    }
    else {
        alert(response);
    }
}

function LoadSubpageTags() {

    var subpageid = document.getElementById("selSubpage").value;
    //var langid = document.getElementById("subpage_langselect").value;


    var postData = "call=LoadSubpageTags&subpageid=" + subpageid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    var secContent = document.getElementById("divSubpageAlt");
    secContent.innerHTML = response;


}

function AddSubpageTag(subpageid) {

    //var langid = document.getElementById("subpage_langselect").value;

    var postData = "call=AddSubpageTag&subpageid=" + subpageid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    if (response.trim() == "ok") {
        LoadSubpageTags();
    }
    else {
        alert(response);
    }


}

function DeleteSubpageTag(subpagetagid, taggroupcode, subpageid) {

    var postData = "call=DeleteSubpageTag&subpagetagid=" + subpagetagid + "&taggroupcode=" + taggroupcode + "&subpageid=" + subpageid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);

    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    if (response.trim() == "ok") {
        LoadSubpageTags(subpageid);
    }
    else {
        alert(response);
    }
}

function AddSubpageChild(parentid, subpageid) {

    //var langid = document.getElementById("subpage_langselect").value;

    var postData = "call=AddSubpageChild&parentid=" + parentid + " &subpageid=" + subpageid;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
    var response = xmlhttp.responseText.replace(/\r\n/g, "");

    if (response.trim() == "ok") {
        LoadSubpageTags(subpageid);
    }
    else {
        alert(response);
    }


}

function LoadTagTypeField(subpagetagid, sel) {

    var parent = sel.parentNode;

    var inputs = parent.getElementsByTagName("INPUT");
    var selTypeVal = sel.nextSibling;

    if (sel.value == 1) {

        for (var i = 0; i < inputs.length; i++) {

            if (inputs[i].id.indexOf("_value_") > 0)
                inputs[i].disabled = false;

        }



        selTypeVal.value = 0;
        selTypeVal.disabled = true;
    }
    else if (sel.value == 2) {

        for (var i = 0; i < inputs.length; i++) {

            if (inputs[i].id.indexOf("_value_") > 0) {
                inputs[i].disabled = true;
                inputs[i].value = "";
            }

        }

        //generic select yüklenecek

        selTypeVal.disabled = false;
    }
    else if (sel.value == 3) {



    }


    /*  var span = document.getElementById(subpagetagid + "_valuespan");
      span.innerHTML = "";
  
      var postData = "call=LoadTagTypeField&subpagetagid=" + subpagetagid +"&value="+type;
  
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
      xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xmlhttp.send(postData);
  
      var response = xmlhttp.responseText.replace(/\r\n/g, "");
      var secContent = document.getElementById(subpagetagid + "_valuespan");
      secContent.innerHTML = response;*/

}

function SaveSubpageTags(subpageid) {

    var saveCounter = 0;
    var counterLabel = document.getElementById("lblcounter");
    counterLabel.innerHTML = saveCounter;

    var subpageid = document.getElementById("selSubpage").value;


    var childs = divContent.getElementsByTagName("*");

    for (var i = 0; i < childs.length; i++) {

        if (childs[i].id.indexOf("page") > 0 || childs[i].id.indexOf("valuespan") > 0 || childs[i].id.indexOf("div") > 0)
            continue;



        if (childs[i].id.indexOf("_") > 0) {

            if (childs[i].disabled == true)
                continue;

            var subpagetagid = childs[i].id.split("_")[0];
            var valueField = childs[i].id.split("_")[1];
            var groupCode = childs[i].id.split("_")[2];
            //var langid = "1";
            var value = childs[i].value;

            //if(valueField=="value")
            //    langid = childs[i].id.split("_")[3];


            var postData = "call=SaveSubpageTags&value=" + encodeURIComponent(value) + "&valueField=" + valueField + "&subpagetagid=" +
                subpagetagid + "&groupcode=" + groupCode + "&subpageid=" + subpageid;
            //+ "&langid=" + langid;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", xhrConnectionPath + "Subpage.php", false);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(postData);
            var response = xmlhttp.responseText.replace(/\r\n/g, "");

            if (response.trim() == "ok") { }
            else {
                alert(response);
                return;
            }

            saveCounter++;
            counterLabel.innerHTML = saveCounter;


        }


    }




    //alert("Kaydedildi.");


    LoadSubpageTags();

}

var globalSubpageTagid;
var globalGroupCode;

function divSelected(divv) {


    var selectedDivs = document.getElementsByClassName("divSelected");

    for (var i = 0; i < selectedDivs.length; i++) {

        selectedDivs[i].classList.remove("divSelected");

    }

    divv.classList.add("divSelected");

    globalSubpageTagid = divv.id.split("_")[0];
    globalGroupCode = divv.id.split("_")[2];

    parametreYukle();

}

function parametreYukle() {

    if (globalSubpageTagid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "SubpageTagParametreYukle");
    data.append("tagid", globalSubpageTagid);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML = response;

    btnAddParameter.style.display = "inline";
    btnSaveParameter.style.display = "inline";
    btnApplyAllParameter.style.display = "none";

    btnSaveParameter.onclick = function () { parametreKaydet(); };

}

function parametreKaydet() {

    if (globalSubpageTagid == null)
        return;


    var params = "";

    var paramDivs = document.getElementsByClassName("divParameter");


    for (var i = 0; i < paramDivs.length; i++) {


        var pType = paramDivs[i].getElementsByTagName("SELECT");
        var pVal = paramDivs[i].getElementsByTagName("INPUT");

        if (pVal.length == 1)//textbox yok ise
            params += "|" + pType[0].value;
        else
            params += "|" + pType[0].value + "=" + pVal[0].value;
    }

    var subpageid = document.getElementById("selSubpage").value;


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "SubpageTagParametreKaydet");
    data.append("baseid", globalSubpageTagid);
    data.append("groupcode", globalGroupCode);
    data.append("subpageid", subpageid);
    data.append("parameter", params.slice(1));


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    }
    else {
        alert(response);
    }

    btnSaveParameter.classList.add("responseOK");

    setTimeout(revertOKParam, 300);

}