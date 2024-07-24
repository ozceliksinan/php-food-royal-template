function selectPanelButton(index) {

    var selectedArr = document.getElementsByClassName("divPanelBtnSelected");

    while (selectedArr.length > 0) {

        var selected = selectedArr[0];
        selected.classList.remove("divPanelBtnSelected");

    }

    var childs = divPanelButtons.children;

    var divPageBtn = childs[index];

    divPageBtn.classList.add("divPanelBtnSelected");





    if (index == 0 || index == 6) {
        // divPages.style.display="flex";
        divPages.style.display = "block";
        divTagList.style.display = "block";

        for (var i = 0; i < childs.length; i++) {
            var divBtn = childs[i];
            divBtn.classList.add("divSmall");
        }
    }
    else {
        divPages.style.display = "none";
        divTagList.style.display = "none";

        for (var i = 0; i < childs.length; i++) {
            var divBtn = childs[i];
            divBtn.classList.remove("divSmall");
        }


    }

    if (index == 0 || index == 6) {
        divContent.classList.remove("divContentWide");
    }
    else {
        divContent.classList.add("divContentWide");
    }

    divParameters.innerHTML = "";
    //divTagEkle.innerHTML="";//genericte yüklendiği yeri bulup ona göre

}

function selectPageButton(id) {

    var selectedArr = document.getElementsByClassName("divPageSelected");

    while (selectedArr.length > 0) {

        var selected = selectedArr[0];
        selected.classList.remove("divPageSelected");

    }

    var childs = divPages.children;


    for (var i = 0; i < childs.length; i++) {

        var divBtn = childs[i];

        if (divBtn.id == id + "_page")
            divBtn.classList.add("divPageSelected");
        else
            divBtn.classList.remove("divPageSelected");

    }



}

function selectDivTag(id) {

    var childs = divTagList.children;

    for (var i = 0; i < childs.length; i++) {

        var divBtn = childs[i];

        if (divBtn.id == id + "_divTagName")
            divBtn.classList.add("divTagSelected");
        else
            divBtn.classList.remove("divTagSelected");

    }

}



function getPanelButtons() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getPanelButtons");

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    if (response.trim() == "login") {

        window.location = "index.html";
        return;
    }

    divPanelButtons.innerHTML = response;

    getPageList();



}


function getPageList() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getPageList");

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divContent.innerHTML = "";

    if (response.trim() == "login") {

        window.location = "index.html";
        return;
    }

    divPages.innerHTML = response;

    selectPanelButton(0);

    LoadPageContent();
}


function LoadImageManagement() {


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getImageManagement");

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divContent.innerHTML = response;

    selectPanelButton(1);

    pPath.innerHTML = "img/";

}

function LoadFileManagement() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getFileManagement");

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divContent.innerHTML = response;

    selectPanelButton(2);

    pPath.innerHTML = "files/";
}





function LoadMetaManagement() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getMetaPageList");

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");

    divContent.innerHTML = "";

    divPages.innerHTML = response;

    selectPanelButton(6);
}

function LoadParameterManagement() {

    selectPanelButton(7);
}









function LoadPageContent(id) {

    if (id == null)
        id = 1;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getPageContent");
    data.append("pageid", id);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divTagList.innerHTML = response;
    divContent.innerHTML = "";

    selectPageButton(id);

}

function LoadPageMetaContent(id) {

    if (id == null)
        id = 1;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getPageMetaContent");
    data.append("pageid", id);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divTagList.innerHTML = response;


    selectPageButton(id);

}

function LoadTagContent(id, type) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getTagContent");
    data.append("tagid", id);
    data.append("tagType", type);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divContent.innerHTML = response;

    loadTagParameters(id);

    selectDivTag(id);

    divSaveBtn.style.display = "block";

    if (type == "text")
        divSaveBtn.onclick = function () { saveTextContent(id); };

    if (type == "value")
        divSaveBtn.onclick = function () { saveValueContent(id); };

    if (type == "img")
        divSaveBtn.onclick = function () { saveImgContent(id); };

    if (type == "generic" || type == "subpage" || type == "list") {

        divSaveBtn.onclick = function () {
            updateTagReference(id);
        };

    }


}

function LoadMetaContent(id, type) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getMetaContent");
    data.append("pageid", id);
    data.append("type", type);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divContent.innerHTML = response;

    divSaveBtn.style.display = "block";

    divSaveBtn.onclick = function () { saveMetaContent(id); };


}

function loadTagParameters(id) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "loadTagParameters");
    data.append("tagid", id);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML = response;

    btnAddParameter.style.display = "inline-block";

}

function saveTextContent(tagid) {

    var secContent = document.getElementById("divContent");

    var childs = secContent.querySelectorAll('*');


    for (var i = 0; i < childs.length; i++) {
        if (childs[i].id == null)
            continue;

        if (childs[i].id.indexOf("_textid") == -1)
            continue;


        var textField = document.getElementById(childs[i].id);

        //var val=textField.innerHTML.replace(/<br>([^<br>]*)$/,'$1');
        var val = textField.innerHTML;
        //webkit yeni satırları div yapıyor bunu temizliyoruz
        val = replaceAll(val, "&lt;div&gt;", "");
        val = replaceAll(val, "&lt;/div&gt;", "");
        val = replaceAll(val, "<div>", "");
        val = replaceAll(val, "</div>", "<br>");

        var xhr = new XMLHttpRequest(),
            data = new FormData();

        data.append("call", "saveTextContent");
        data.append("textid", textField.id.replace("_textid", ""));
        data.append("textVal", val);

        xhr.addEventListener('load', function (e) {
        });
        xhr.upload.addEventListener('progress', function (e) {
        });

        xhr.open('POST', xhrConnectionPath + "main.php", false);
        xhr.send(data);

        var response = xhr.responseText.replace(/\r\n/g, "");


        if (response.trim() != "ok") {
            alert(response);
            return;
        }
    }

    saveTagParameters(tagid);

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);


}

function saveMetaContent(metaid) {

    var secContent = document.getElementById("divContent");

    var childs = secContent.querySelectorAll('*');


    for (var i = 0; i < childs.length; i++) {
        if (childs[i].id == null)
            continue;

        if (childs[i].id.indexOf("_textid") == -1)
            continue;


        var textField = document.getElementById(childs[i].id);

        var val = textField.innerHTML.replace(/<br>([^<br>]*)$/, '$1');

        var xhr = new XMLHttpRequest(),
            data = new FormData();

        data.append("call", "saveMetaContent");
        data.append("metaid", textField.id.replace("_textid", ""));
        data.append("value", val);

        xhr.addEventListener('load', function (e) {
        });
        xhr.upload.addEventListener('progress', function (e) {
        });

        xhr.open('POST', xhrConnectionPath + "main.php", false);
        xhr.send(data);

        var response = xhr.responseText.replace(/\r\n/g, "");


        if (response.trim() != "ok") {
            alert(response);
            return;
        }
    }


    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);

}

function saveValueContent(tagid) {

    var secContent = document.getElementById("divContent");

    var childs = secContent.querySelectorAll('*');


    for (var i = 0; i < childs.length; i++) {
        if (childs[i].id == null)
            continue;

        if (childs[i].id.indexOf("_valid") == -1)
            continue;


        var textField = document.getElementById(childs[i].id);

        var val = textField.innerHTML.replace(/<br>([^<br>]*)$/, '$1');


        var xhr = new XMLHttpRequest(),
            data = new FormData();

        data.append("call", "saveValueContent");
        data.append("valid", textField.id.replace("_valid", ""));
        data.append("value", val);

        xhr.addEventListener('load', function (e) {
        });
        xhr.upload.addEventListener('progress', function (e) {
        });

        xhr.open('POST', xhrConnectionPath + "main.php", false);
        xhr.send(data);

        var response = xhr.responseText.replace(/\r\n/g, "");


        if (response.trim() != "ok") {
            alert(response);
            return;
        }
    }

    saveTagParameters(tagid);

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);


}

function saveImgContent(tagid) {


    var childs = divFolderContainer.children;

    var path = "";

    for (var i = 0; i < childs.length; i++) {

        var divFolder = childs[i];

        var selectedFolderParent = divFolder.getElementsByClassName("divFolderSelected");
        var selectedFileParent = divFolder.getElementsByClassName("divFileSelected");

        if (selectedFolderParent.length > 0) {

            var sp = selectedFolderParent[0].childNodes[0];

            path += sp.innerHTML + "/";

        }
        else if (selectedFileParent.length > 0) {

            var sp = selectedFileParent[0].childNodes[0];

            path += sp.innerHTML;

        }


    }


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "saveImgValue");
    data.append("tagid", tagid);
    data.append("value", path);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    if (response.trim() != "ok") {
        alert(response);
        return;
    }

    saveTagParameters(tagid);

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);


}

function updateTagReference(tagid) {

    var divSelecteds = divContent.getElementsByClassName("divFolderSelected");

    if (divSelecteds.length != 1) {

        saveTagParameters(tagid);
        divSaveBtn.classList.add("responseOK");
        setTimeout(revertOK, 300);
        return;
    }


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "updateTagReference");
    data.append("tagid", tagid);
    data.append("referenceid", divSelecteds[0].id.replace("_ref", ""));

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    if (response.trim() != "ok") {
        alert(response);
        return;
    }

    saveTagParameters(tagid);

    divSaveBtn.classList.add("responseOK");

    setTimeout(revertOK, 300);


}

function revertOK() {

    divSaveBtn.classList.remove("responseOK");

}

function revertOKParam() {

    btnSaveParameter.classList.remove("responseOK");

}
function revertOKParamAll() {

    btnApplyAllParameter.classList.remove("responseOK");

}
function revertOKApplyAll() {

    divApplyAll.classList.remove("responseOK");

}
function revertOKDelete() {

    divApplyAll.classList.remove("responseOK");

}







function addParameterDiv() {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "addParameter");


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divParameters.innerHTML += response;

}

function removeParameterDiv(button) {

    var parentDiv = button.parentNode;
    parentDiv.parentNode.removeChild(parentDiv);

}

function saveTagParameters(id) {

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



    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "saveTagParameters");
    data.append("tagid", id);
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


}

function checkParamHasVal(sel) {

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "checkParamHasVal");
    data.append("val", sel.value);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "Parameters.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();


    var parent = sel.parentNode;

    var inputs = parent.childNodes;


    if (response == '1') {

        if (inputs.length == 2) {

            var input = document.createElement('input');
            input.type = "text";
            parent.insertBefore(input, inputs[1]);

        }

    }
    else {

        if (inputs.length == 3) {

            parent.removeChild(inputs[1]);

        }

    }



}








function selectFolder(folder, div) {



    var childs = divFolderContainer.children;


    var divParent = div.parentNode;


    var remove = false;
    var path = "";


    for (var i = 0; i < childs.length; i++) {

        var divItem = childs[i];


        if (remove) {
            divFolderContainer.removeChild(divItem);
            i--;
            continue;
        }


        if (childs[i] == divParent) {
            remove = true;
            path += folder;

            var selectedFolders = divItem.getElementsByClassName("divFolderSelected");
            if (selectedFolders.length > 0) {
                var selectedFolder = selectedFolders[0];
                selectedFolder.className = "divFolder";
            }

            div.className = "divFolderSelected";
            continue;
        }

        var selectedFolders = divItem.getElementsByClassName("divFolderSelected");

        if (selectedFolders.length > 0) {

            var sp = selectedFolders[0].childNodes[0];

            path += sp.innerHTML + "/";

        }

        var selectedFiles = divFolderContainer.getElementsByClassName("divFileSelected");
        if (selectedFiles.length > 0) {
            var selectedFile = selectedFiles[0];
            selectedFile.className = "divFile";
        }


    }




    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getSingleFolderContents");
    data.append("path", path);
    data.append("folder", folder);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divFolderContainer.innerHTML += response;


    divFolderContainer.scrollLeft = divFolderContainer.offsetWidth;



}

function selectFile(div) {

    var childs = divFolderContainer.children;


    var divParent = div.parentNode;



    var remove = false;

    for (var i = 0; i < childs.length; i++) {

        var divItem = childs[i];

        if (remove) {
            divFolderContainer.removeChild(divItem);
            i--;
        }


        if (childs[i] == divParent) {
            remove = true;

            var selectedFiles = divFolderContainer.getElementsByClassName("divFileSelected");
            if (selectedFiles.length > 0) {
                var selectedFile = selectedFiles[0];
                selectedFile.className = "divFile";
            }

            div.className = "divFileSelected";
            continue;
        }


    }




}

function selectFolderForManagement(root, folder, div) {


    var childs = divFolderContainer.children;

    var divParent;
    if (div != null)
        divParent = div.parentNode;

    if (folder == "" && childs.length == 1) {

        folder = root.substr(0, root.length - 1);
        divFolderContainer.removeChild(childs[0]);
    }


    var remove = false;
    var path = "";



    for (var i = 0; i < childs.length; i++) {

        var divItem = childs[i];


        if (remove) {
            divFolderContainer.removeChild(divItem);
            i--;
            continue;
        }


        if (childs[i] == divParent) {
            remove = true;
            path += folder + "/";

            var selectedFolders = divItem.getElementsByClassName("divFolderSelected");
            if (selectedFolders.length > 0) {
                var selectedFolder = selectedFolders[0];
                selectedFolder.className = "divFolder";
            }

            div.className = "divFolderSelected";
            continue;
        }

        var selectedFolders = divItem.getElementsByClassName("divFolderSelected");

        if (selectedFolders.length > 0) {

            var sp = selectedFolders[0].childNodes[0];

            path += sp.innerHTML + "/";

        }



    }



    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "getSingleFolderContentsForManagement");
    data.append("root", root);
    data.append("path", path);
    data.append("folder", folder);
    data.append("index", childs.length);

    xhr.addEventListener('load', function (e) {
    });
    xhr.upload.addEventListener('progress', function (e) {
    });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "");


    divFolderContainer.innerHTML += response;


    divFolderContainer.scrollLeft = divFolderContainer.offsetWidth;

    pPath.innerHTML = root + path;

    loadFolderFiles(pPath.innerHTML);
}



function UploadFile() {

    if (window.File && window.FileReader && window.FileList && window.Blob) {
        // Great success! All the File APIs are supported.
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }

    var file = document.getElementById("fileUpload").files[0];

    if (file == null)
        return;

    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "UploadFile");
    data.append("path", pPath.innerHTML + file.name);
    data.append("file", file); // You don't need to use a FileReader

    // append your post fields

    // attach your events
    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        pUploadResult.innerHTML = "Dosya yüklendi.";
    }
    else {
        pUploadResult.innerHTML = "Dosya yüklenirken hata oluştu!";
    }


    loadFolderFiles(pPath.innerHTML);


}


function close_Popup() {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {
        popups[i].style.display = "none";
    }

}

function AddPagePopup() {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "addPage")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

}

function addPage(pageName, pageDB) {


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "addPage");
    data.append("pageName", pageName);
    data.append("pageDB", pageDB);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

        getPageList();
    }
    else {
        alert(response);
    }


}


function addFolderPop(root, path) {


    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "addFolder")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    btnAddFolder.dataset.root = root;
    btnAddFolder.dataset.path = path;

}

function addFolder(value) {

    var root = btnAddFolder.dataset.root;
    var path = btnAddFolder.dataset.path;

    var pathArr = path.split("/");

    if (pathArr.length > 1)
        if (pathArr[0] != root) {
            pathArr.splice(0, 0, root);
        }


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "addFolder");
    data.append("root", root);
    data.append("path", path);
    data.append("folder", value);
    data.append("index", pathArr.length - 1);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {

        var childs = divFolderContainer.children;
        var divContent = childs[pathArr.length - 3];

        var divFolders = divContent.children;
        var divFolderSelectedd;

        for (var i = 1; i < divFolders.length - 1; i++) {

            if (divFolders[i].children[0].innerHTML == pathArr[pathArr.length - 2]) {

                divFolderSelectedd = divFolders[i];
                break;

            }

        }

        if (divFolderSelectedd != null)
            selectFolderForManagement(root, pathArr[pathArr.length - 2], divFolderSelectedd);
        else if (path == "/")
            selectFolderForManagement(root, '', null);

    }
    else {
        alert(response);
    }




}

function selectReferenceItem(that) {


    var divSelected = divContent.getElementsByClassName("divFolderSelected");

    if (divSelected.length > 0) {

        var div = divSelected[0];
        div.className = "divFolder";
    }

    that.className = "divFolderSelected";

}

function resetScreen() {

    //sayfalar ve panel buttonlara basınca ilk bu çalışıp ekranı silecek

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
    }
    else {
        alert(response);
    }

}


var _onPaste_StripFormatting_IEPaste = false;

function OnPaste_StripFormatting(elem, e) {

    if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    }
    else if (e.clipboardData && e.clipboardData.getData) {
        e.preventDefault();
        var text = e.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    }
    else if (window.clipboardData && window.clipboardData.getData) {
        // Stop stack overflow
        if (!_onPaste_StripFormatting_IEPaste) {
            _onPaste_StripFormatting_IEPaste = true;
            e.preventDefault();
            window.document.execCommand('ms-pasteTextOnly', false);
        }
        _onPaste_StripFormatting_IEPaste = false;
    }

}

function togglePasteWithStyle() {


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "togglePasteWithStyle");


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    spPasteWithStyle.innerText = response;

}



function fileDeleteConfirm(fileName) {

    var popups = document.getElementsByClassName("popup");

    for (var i = 0; i < popups.length; i++) {

        if (popups[i].dataset.poptype == "fileDelete")
            popups[i].style.display = "block";
        else
            popups[i].style.display = "none";
    }

    btnFileDelete.dataset.fileName = fileName;

}

function fileDelete(btn) {

    var fileName = btn.dataset.fileName;


    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "deleteFile");
    data.append("path", pPath.innerHTML);
    data.append("fileName", fileName);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    if (response == "ok") {
        loadFolderFiles(pPath.innerHTML);
    }
    else {
        alert(response);
    }

}

function loadFolderFiles(path) {

    //dosya veya resim tipine göre parametre gidecek
    var type = "";
    var btns = document.querySelectorAll(".divPanelButton");
    for (var i = 0; i < btns.length; i++) {

        if (btns[i].classList.length > 1) {
            if (i == 1)
                type = "image";
            else
                type = "file";

            break;
        }


    }



    var xhr = new XMLHttpRequest(),
        data = new FormData();

    data.append("call", "loadFolderFiles");
    data.append("path", path);
    data.append("type", type);


    xhr.addEventListener('load', function (e) { });
    xhr.upload.addEventListener('progress', function (e) { });

    xhr.open('POST', xhrConnectionPath + "main.php", false);
    xhr.send(data);

    var response = xhr.responseText.replace(/\r\n/g, "").trim();

    divFiles.innerHTML = response;

}

function convertToRaw(btn) {

    var textDiv = btn.parentNode.nextSibling;

    var p = document.createElement("p");
    p.appendChild(document.createTextNode(textDiv.innerHTML));

    textDiv.innerHTML = p.innerHTML;

}

function convertToFormatted(btn) {

    var textDiv = btn.parentNode.nextSibling;


    textDiv.innerHTML = textDiv.innerText;



}

