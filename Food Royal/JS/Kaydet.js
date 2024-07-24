function SayfaKaydet() {

    var elements = document.getElementsByTagName("*");

    var xmlhttp = new XMLHttpRequest();

    for (var i = 0; i < elements.length; i++) {
        if (elements[i].id.trim() == "")
            continue;

        if (elements[i].id.length == 0)
            continue;

        if (elements[i].id[0] == "_")
            continue;

        var htmlid = "";
        var tagName = "";
        var tagType = "";

        htmlid = elements[i].id;
        tagName = elements[i].tagName;
        //tagType = elements[i].type;

        tagType = elements[i].dataset.tagtype;

        var postData = "Htmlid=" + htmlid + "&" +
            "TagName=" + tagName + "&" +
            "TagType=" + tagType;

        xmlhttp.open("POST", xhrConnectionPath + "Kaydet.php", false);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(postData);

        var response = xmlhttp.responseText.replace(/\r\n/g, "");

        if (response.trim() != "ok") {
            alert(xmlhttp.responseText);
            return;
        }

    }

    alert("Tamamlandı");

}