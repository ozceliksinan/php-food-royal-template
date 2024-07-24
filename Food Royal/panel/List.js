function LoadListManagement() {

    //setBackground(0);
 
    var postData = "call=GetListManager";
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    divContent.innerHTML = response;
 
    divPages.innerHTML = "";
 
    divSaveBtn.style.display = "none";
    //divSaveBtn.onclick=function(){ baseGrupKaydet(); };
 
    divApplyAll.style.display = "none";
    //divApplyAll.onclick=function(){ baseGrupTumuneUygulaConfirm(); };
 
    selectPanelButton(5);
 
 }
 
 function AddList() {
 
    var txt = document.getElementById("txtListeAdi");
 
    var postData = "call=AddList&listName=" + txt.value;
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    if (response.trim() == "ok") {
       LoadListManagement();
    } else {
       alert(response);
    }
 
 }
 
 function DeleteList() {
 
    var select = document.getElementById("selLists");
 
    var postData = "call=DeleteList&listid=" + select.value;
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    if (response.trim() == "ok") {
       LoadListManagement();
    } else {
       alert(response);
    }
 }
 
 function LoadList(listid, langid) {
 
    var postData = "call=LoadList&listid=" + listid + "&langid=" + langid;
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    var secContent = document.getElementById("divLists");
    secContent.innerHTML = response;
 
 }
 
 function AddListElement(listid) {
 
    var postData = "call=AddListElement&listid=" + listid;
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    if (response.trim() == "ok") {
       LoadList(listid, 1);
    } else {
       alert(response);
    }
 
 }
 
 function DeleteListElement(listid, itemid) {
 
    var postData = "call=DeleteListElement&itemid=" + itemid;
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
 
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    if (response.trim() == "ok") {
       LoadList(listid, 1);
    } else {
       alert(response);
    }
 
 }
 
 function ListElementsUpdate(listid) {
 
    var paramvalue = document.getElementById(listid + "_listparam").value;
    var tagvalue = document.getElementById(listid + "_listtag").value;
    var langid = document.getElementById("list_langselect").value;
 
    var postData = "call=ListUpdate&listid=" + listid + "&parameter=" + encodeURIComponent(paramvalue) + "&tagvalue=" + encodeURIComponent(tagvalue);
 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(postData);
    var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
    if (response.trim() == "ok") {} else {
       alert(response);
       return;
    }
 
    var childs = document.getElementsByTagName("*");
 
    for (var i = 0; i < childs.length; i++) {
 
       if (childs[i].id.indexOf("page") > 0 || childs[i].id.indexOf("valuespan") > 0)
          continue;
 
       if (childs[i].id.indexOf("_") > 0) {
 
          //$elementRow["id"]."_elementparam
          //$elementRow["id"]."_elementname
          //$elementRow["id"]."_elementvalue
 
          var elementid = childs[i].id.split("_")[0];
          var valueField = childs[i].id.split("_")[1];
          var value = childs[i].value;
 
          var postData = "call=ListElementsUpdate&value=" + encodeURIComponent(value) + "&valueField=" + encodeURIComponent(valueField) + "&elementid=" + encodeURIComponent(elementid);
 
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("POST", xhrConnectionPath + "List.php", false);
          xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xmlhttp.send(postData);
          var response = xmlhttp.responseText.replace(/\r\n/g, "");
 
          if (response.trim() == "ok") {} else {
             alert(response);
             return;
          }
 
       }
    }
 
    alert("Kaydedildi.");
 
    LoadList(listid, langid);
 
 }