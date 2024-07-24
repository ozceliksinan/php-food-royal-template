function LoadGenericManagement() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericGroupSayfaYukle");

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divContent.innerHTML = response;

    divSaveBtn.style.display = "block";
    divSaveBtn.onclick = function () {
        baseGrupKaydet();
    };

    ////divApplyAll.style.display="block"; kontrol edilmesi lazım düzgün çalışmıyor
    ////divApplyAll.onclick=function(){ baseGrupTumuneUygulaConfirm(); };

    tagEkleYukle();

    selectPanelButton(3);

    getGroupList();

}

function tagEkleYukle() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "divTagEkleYukle");

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divTagEkle.innerHTML = response;
    divTagEkle.style.display = "block";

}

function getGroupList() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getGroupList");

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divPages.style.display = "flex";
    divPages.innerHTML = response;

    selectPageButton(0);

}

function LoadGenericGroup(groupid) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "LoadGenericGroup");
    data.append("groupid", groupid);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divTagList.innerHTML = response;

    selectPageButton(groupid);

    divContent.innerHTML = "";
    divContent.classList.remove("divContentWide");
    divTagList.style.display = "block";
    divTagEkle.style.display = "none";
    divApplyAll.style.display = "none";

}

function genericGrupEklePop() {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "genericGrupEkle")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

}

function genericGrupEkle(value) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericGrupEkle");
    data.append("isim", value);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        LoadGenericManagement();
    } else {
        alert(response);
    }

}

var globalGroupid;
var globalBaseTagid;

function genericBaseYukle(grupid) {

    var selectedDivs = document.getElementsByClassName("divGroupSelected");

    while (selectedDivs.length > 0) {
        selectedDivs[0].classList.remove("divGroupSelected");
    }

    var div = document.getElementById("grup_" + grupid);
    div.classList.add("divGroupSelected");

    globalGroupid = grupid;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericBaseYukle");
    data.append("grupid", grupid);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divGenericTemplate.innerHTML = response;

    divParameters.innerHTML = "";

}

function tagEkleSec(tagdiv) {

    var selectedDivs = document.getElementsByClassName("divGenericTagSelected");

    while (selectedDivs.length > 0) {
        selectedDivs[0].classList.remove("divGenericTagSelected");
    }

    var div = document.getElementById(tagdiv);
    div.classList.add("divGenericTagSelected");

}

function genericTagEkle() {

    var selectedDivs = document.getElementsByClassName("divGenericTagSelected");

    if (selectedDivs.length == 0)
        return;

    var spTag = selectedDivs[0].firstChild;

    if (spTag == null)
        return;

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericTagEkle");
    data.append("grupid", globalGroupid);
    data.append("tag", spTag.innerHTML);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function baseTagSec(id) {

    var header = document.getElementById("headerTag_" + id);
    var baseTag = document.getElementById("baseTag_" + id);

    for (var i = 0; i < header.classList.length; i++) {
        if (header.classList[i] == "baseTargetHeader")
            addBaseChild(id);
    }

    var selectedHeaders = document.getElementsByClassName("baseHeaderSelected");
    var selectedTags = document.getElementsByClassName("baseTagSelected");

    while (selectedHeaders.length > 0) {
        selectedHeaders[0].classList.remove("baseHeaderSelected");
    }
    while (selectedTags.length > 0) {
        selectedTags[0].classList.remove("baseTagSelected");
    }

    header.classList.add("baseHeaderSelected");
    baseTag.classList.add("baseTagSelected");

    globalBaseTagid = id;

    baseTagParametreYukle(id);

}

function showBaseTargets() {

    var childs = divGenericTemplate.querySelectorAll('*');

    if (childs.length == 0)
        return;

    for (var i = 0; i < childs.length; i++) {

        if (childs[i].id.indexOf('headerTag_') == 0) {

            var selected = false;

            for (var j = 0; j < childs[i].classList.length; j++) {
                if (childs[i].classList[j] == "baseHeaderSelected")
                    selected = true;
            }

            if (selected)
                continue;

            var span = childs[i].children[0];
            if (span.innerHTML == "div") {
                childs[i].classList.add("baseTargetHeader");
            }
        }

    }

}

function addBaseChild(parentid) {

    if (globalGroupid == null)
        return;
    if (globalBaseTagid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "addBaseChild");
    data.append("grupid", globalGroupid);
    data.append("parentid", parentid);
    data.append("childid", globalBaseTagid);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function removeBaseChild(id) {

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "removeBaseChild");
    data.append("grupid", globalGroupid);
    data.append("childid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function baseTagUp(id) {

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagUp");
    data.append("grupid", globalGroupid);
    data.append("tagid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function baseTagDown(id) {

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagDown");
    data.append("grupid", globalGroupid);
    data.append("tagid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function baseTagDeleteConfirm(id) {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "baseTagDelete")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    btnTagDelete.dataset.id = id;

}

function baseTagDelete(btnTagDelete) {

    var id = btnTagDelete.dataset.id;

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagDelete");
    data.append("grupid", globalGroupid);
    data.append("tagid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        genericBaseYukle(globalGroupid);
    } else {
        alert(response);
    }

}

function baseTagParametreYukle(id) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagParametreYukle");
    data.append("baseid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML = response;

    btnAddParameter.style.display = "inline";
    btnSaveParameter.style.display = "inline";
    btnApplyAllParameter.style.display = "inline";

    btnSaveParameter.onclick = function () {
        baseTagParametreKaydet();
    };

}

function baseTagParametreKaydet() {

    if (globalBaseTagid == null)
        return;

    var params = "";

    var paramDivs = document.getElementsByClassName("divParameter");

    for (var i = 0; i < paramDivs.length; i++) {

        var pType = paramDivs[i].getElementsByTagName("SELECT");
        var pVal = paramDivs[i].getElementsByTagName("INPUT");

        if (pVal.length == 1) //textbox yok ise
            params += "|" + pType[0].value;
        else
            params += "|" + pType[0].value + "=" + pVal[0].value;
    }

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagParametreKaydet");
    data.append("baseid", globalBaseTagid);
    data.append("parameter", params.slice(1));

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    } else {
        alert(response);
    }

    btnSaveParameter.classList.add("responseOK");

    setTimeout(revertOKParam, 300);

}

function baseTagParametreTumuneUygula() {

    if (globalBaseTagid == null)
        return;

    var params = "";

    var paramDivs = document.getElementsByClassName("divParameter");

    for (var i = 0; i < paramDivs.length; i++) {

        var pType = paramDivs[i].getElementsByTagName("SELECT");
        var pVal = paramDivs[i].getElementsByTagName("INPUT");

        if (pVal.length == 1) //textbox yok ise
            params += "|" + pType[0].value;
        else
            params += "|" + pType[0].value + "=" + pVal[0].value;
    }

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseTagParametreTumuneUygula");
    data.append("baseid", globalBaseTagid);
    data.append("parameter", params.slice(1));

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    } else {
        alert(response);
    }

    btnApplyAllParameter.classList.add("responseOK");

    setTimeout(revertOKParamAll, 300);

}

function baseGrupKaydet() {

    if (globalGroupid == null)
        return;

    //var childs = divGenericTemplate.childNodes;

    var childs = divGenericTemplate.getElementsByTagName('*');

    if (childs.length == 0)
        return;

    for (var i = 0; i < childs.length; i++) {

        if (childs[i].id.indexOf('_value') == -1)
            continue;

        var value = childs[i].value;
        var baseid = 0;

        baseid = childs[i].id.replace("_value", "");

        var xhr = new XMLHttpRequest(),
            data = new FormData();

        data.append("call", "baseTagValueKaydet");
        data.append("value", value);
        data.append("baseid", baseid);

        xhr.addEventListener('load', function (e) { });
        xhr.upload.addEventListener('progress', function (e) { });

        xhr.open('POST', xhrConnectionPath + "Generic.php", false);
        xhr.send(data);

        var response = xhr.responseText.replace(/\r\n/g, "").trim();

        if (response == "ok") {

        } else {
            alert(response);
            return;
        }

    }

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);

}

function baseGrupTumuneUygulaConfirm(order) {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "baseTumuneUygula")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    //            btnBlogDelete.dataset.blogid = blogid;
    //            btnBlogDelete.dataset.order = order;

}

function baseGrupTumuneUygula() {

    if (globalGroupid == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "baseGrupTumuneUygula");
    data.append("grupid", globalGroupid);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    } else {
        alert(response);
    }

    divApplyAll.classList.add("responseOK");

    setTimeout(revertOKApplyAll, 300);

}

function loadBaseImgs(selid, dir) {

    var sel = document.getElementById(selid);

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getFolderImgOptions");
    data.append("dir", dir);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "/Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    sel.innerHTML = response;

}

function loadBaseImg(id) {

    var selFolder = document.getElementById(id + "_value_baseImg");
    var selImg = document.getElementById(id + "_selImg");
    var Img = document.getElementById(id + "_img");

    var folder = selFolder.value + "/";

    if (folder == "root/")
        folder = "";

    Img.src = "../img/" + folder + selImg.value;

}

function selectGeneric(id) {

    var childs = divTagList.children;

    for (var i = 0; i < childs.length; i++) {

        var divBtn = childs[i];

        if (divBtn.id == id + "_gen")
            divBtn.classList.add("divTagSelected");
        else
            divBtn.classList.remove("divTagSelected");

    }

}

function ShowGenericDetail(groupid, id, order) {

    selectGeneric(id);

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "ShowGenericDetail");
    data.append("id", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divContent.innerHTML = response;

    LoadGenericParams(id, "generic");

    divDeleteBtn.style.display = "block";

    divSaveBtn.onclick = function () {
        SaveGenericContent(id);
    };
    divDeleteBtn.onclick = function () {
        GenericDeletePop(groupid, id, order);
    };

    genericLoadImgs();

}

function SaveGenericContent(id) {

    var isim = document.getElementById("genIsim").value;
    var urlName = document.getElementById("genUrlName").value;

    var masterid = document.getElementById(id + "_genericmaster").value;
    var targetid = document.getElementById(id + "_generictarget").value;

    var tarihArr = document.getElementById("genTarih").value.split(".");
    var saat = document.getElementById("genSaat").value;

    var date = tarihArr[2] + "-" + tarihArr[1] + "-" + tarihArr[0] + " " + saat + ":00";

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "SaveGenericContent");
    data.append("genericid", id);
    data.append("isim", isim);
    data.append("urlName", urlName);
    data.append("masterid", masterid);
    data.append("targetid", targetid);
    data.append("date", date);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        GenericElementsUpdate();
    } else {
        alert(response);
        return;

    }

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);

}

function GenericElementsUpdate() {

    var childs = divContent.getElementsByTagName('*');

    for (var i = 0; i < childs.length; i++) {
        if (childs[i].id.indexOf("_tagelement") < 0) {
            continue;
        }

        var elementid = childs[i].id.split("_")[0];
        //var valueField = childs[i].id.split("_")[1];
        var value = childs[i].innerHTML;

        if (childs[i].tagName == "INPUT") { //hidden seçiyor

            value = childs[i].value;

        }

        if (value == null)
            value = "";

        //webkit yeni satırları div yapıyor bunu temizliyoruz
        value = replaceAll(value, "&lt;div&gt;", "");
        value = replaceAll(value, "&lt;/div&gt;", "");
        value = replaceAll(value, "<div>", "");
        value = replaceAll(value, "</div>", "<br>");

        var xhr = new XMLHttpRequest(),
            data = new FormData();

        data.append("call", "GenericElementsUpdate");
        data.append("elementid", elementid);
        data.append("value", value);

        xhr.addEventListener('load', function (e) { });
        xhr.upload.addEventListener('progress', function (e) { });

        xhr.open('POST', xhrConnectionPath + "Generic.php", false);
        xhr.send(data);

        var response = xhr.responseText.replace(/\r\n/g, "").trim();

        if (response.trim() == "ok") {

        } else {
            alert(response);
            return;
        }
    }

}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    //return str.replace(new RegExp(find, 'g'), replace);
}

function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function LoadGenericParams(id, type) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "LoadGenericParams");
    data.append("id", id);
    data.append("type", type);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML = response;

    btnAddParameter.style.display = "inline-block";
    btnSaveParameter.style.display = "inline-block";

    btnSaveParameter.onclick = function () {
        SaveGenericParameter(id, "generic");
    };

    spParamsHeader.innerHTML = "Generic Params";

}

function SaveGenericParameter(id, type) {

    var params = "";

    var paramDivs = document.getElementsByClassName("divParameter");

    for (var i = 0; i < paramDivs.length; i++) {

        var pType = paramDivs[i].getElementsByTagName("SELECT");
        var pVal = paramDivs[i].getElementsByTagName("INPUT");

        if (pVal.length == 1) //textbox yok ise
            params += "|" + pType[0].value;
        else
            params += "|" + pType[0].value + "=" + pVal[0].value;
    }

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "SaveGenericParameter");
    data.append("id", id);
    data.append("type", type);
    data.append("parameter", params.slice(1));

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    } else {
        alert(response);
        return;
    }

    btnSaveParameter.classList.add("responseOK");

    setTimeout(revertOKParam, 300);

}

function genericEklePop(groupid) {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "genericEkle")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    btnAddGeneric.dataset.grup = groupid;

}

function genericEkle(value) {

    var groupid = btnAddGeneric.dataset.grup;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericEkle");
    data.append("isim", value);
    data.append("groupid", groupid);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        LoadGenericGroup(groupid);
    } else {
        alert(response);
    }

}

function GenericUp(groupid, genericid, order) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "GenericUp");
    data.append("groupid", groupid);
    data.append("genericid", genericid);
    data.append("order", order);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

        LoadGenericGroup(groupid);
        ShowGenericDetail(groupid, genericid, order);
    } else {
        alert(response);
        return;
    }

}

function GenericDown(groupid, genericid, order) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "GenericDown");
    data.append("groupid", groupid);
    data.append("genericid", genericid);
    data.append("order", order);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

        LoadGenericGroup(groupid);
        ShowGenericDetail(groupid, genericid, order);

    } else {
        alert(response);
        return;
    }

}

function GenericDeletePop(groupid, genericid, order) {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "genericDelete")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    btnGenericDelete.dataset.group = groupid;
    btnGenericDelete.dataset.genericid = genericid;
    btnGenericDelete.dataset.order = order;

}

function GenericDelete() {

    var groupid = btnGenericDelete.dataset.group;
    var genericid = btnGenericDelete.dataset.genericid;
    var order = btnGenericDelete.dataset.order;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "GenericDelete");
    data.append("groupid", groupid);
    data.append("genericid", genericid);
    data.append("order", order);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

        LoadGenericGroup(groupid);
        divContent.innerHTML = "";

    } else {
        alert(response);
        return;
    }

}

function genericTagSec(id, langid, baseid, parentid) {

    var header = document.getElementById("headerTag_" + id);
    var genTag = document.getElementById("genTag_" + id);

    /* for(var i=0;i<header.classList.length;i++){
         if(header.classList[i]=="baseTargetHeader")
             addBaseChild(id);
     }*/

    var selectedHeaders = document.getElementsByClassName("baseHeaderSelected");
    var selectedTags = document.getElementsByClassName("baseTagSelected");

    while (selectedHeaders.length > 0) {
        selectedHeaders[0].classList.remove("baseHeaderSelected");
    }
    while (selectedTags.length > 0) {
        selectedTags[0].classList.remove("baseTagSelected");
    }

    header.classList.add("baseHeaderSelected");
    genTag.classList.add("baseTagSelected");

    //globalBaseTagid=id;

    genericTagParametreYukle(id, langid, baseid, parentid);

}

function genericTagParametreYukle(id, langid, baseid, parentid) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericTagParametreYukle");
    data.append("genid", id);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML = response;

    btnAddParameter.style.display = "inline";
    btnSaveParameter.style.display = "inline";
    btnApplyAllParameter.style.display = "none";

    btnSaveParameter.onclick = function () {
        genericTagParametreKaydet(id, langid, baseid, parentid);
    };

}

function genericTagParametreKaydet(id, langid, baseid, parentid) {

    var params = "";

    var paramDivs = document.getElementsByClassName("divParameter");

    for (var i = 0; i < paramDivs.length; i++) {

        var pType = paramDivs[i].getElementsByTagName("SELECT");
        var pVal = paramDivs[i].getElementsByTagName("INPUT");

        if (pVal.length == 1) //textbox yok ise
            params += "|" + pType[0].value;
        else
            params += "|" + pType[0].value + "=" + pVal[0].value;
    }

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "genericTagParametreKaydet");
    data.append("id", id);
    data.append("langid", langid);
    data.append("baseid", baseid);
    data.append("parentid", parentid);

    data.append("parameter", params.slice(1));

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

    } else {
        alert(response);
    }

    btnSaveParameter.classList.add("responseOK");

    setTimeout(revertOKParam, 300);

}

function baseImgOnchange(sel) {

    var parentDiv = sel.parentNode;
    var childs = parentDiv.children;

    var path = "";
    var removeChild = false;

    for (var i = 0; i < childs.length; i++) {

        var select = childs[i];

        if (removeChild) {
            parentDiv.removeChild(select);
            i--;
            continue;
        }

        path += select.value + "/";

        if (select == sel) {
            removeChild = true;
        }

    }

    var tagid = parentDiv.id.replace("divSelects_", "");
    var hdn = document.getElementById(tagid + "_tagelement");
    var img = document.getElementById(tagid + "_img");

    if (select.value == "") {
        hdn.value = "";
        img.src = "";
        return;
    }

    while (path[path.length - 2] == '/')
        path = path.slice(path.length - 2, 1);

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getSingleFolderSelect");
    data.append("path", path);

    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Generic.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    //////////////////////////////

    //alert(response);
    //return;

    //////////////////////////////

    var tagid = parentDiv.id.replace("divSelects_", "");

    var hdn = document.getElementById(tagid + "_tagelement");
    if (hdn == null)
        hdn = document.getElementById(tagid + "_value"); //base ve tagelement aynı fonksiyonu kullanıyor
    hdn.value = path.replace(/\/$/, "");

    if (response == "loadimg") {

        img.src = "../img/" + path.replace(/\/$/, "");

    } else {

        //alert(response);
        //return;

        if (sel.value != "") {

            var node = document.createElement("SELECT");
            node.innerHTML = response;
            node.onclick = function () {
                baseImgOnchange(this);
            };
            parentDiv.appendChild(node);
        }
    }

}

function genericLoadImgs() {

    var divs = document.getElementsByClassName("divSelects");

    for (var divCounter = 0; divCounter < divs.length; divCounter++) {

        var childs = divs[divCounter].children;

        var lastSel = childs[childs.length - 1];

        baseImgOnchange(lastSel);

    }

}