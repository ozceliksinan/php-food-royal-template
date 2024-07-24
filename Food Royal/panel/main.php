<?php

include "PanelGenel.php";

if (empty($_POST["call"])) {
    echo "*error* Yükleme fonksiyonu alınamadı!";
    return;
}
$callFunction = $_POST["call"];

if ($callFunction == "login") {
    if (!isset($_POST["user"]) || !isset($_POST["pass"])) {
        echo "*error* username/password alınamadı!";
        return;
    }

    login($conn, $_POST["user"], $_POST["pass"]);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getPanelButtons") {
    getPanelButtons($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getPageList") {
    getPageList($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getMetaPageList") {
    getMetaPageList($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getPageContent") {
    getPageContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getPageMetaContent") {
    getPageMetaContent();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "getTagContent") {
    getTagContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getMetaContent") {
    getMetaContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "saveTextContent") {
    saveTextContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "saveMetaContent") {
    saveMetaContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "saveValueContent") {
    saveValueContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "saveImgValue") {
    saveImgValue($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getSingleFolderContents") {
    getSingleFolderContents();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "getImageManagement") {
    getImageManagement();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "getFileManagement") {
    getFileManagement();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "getSingleFolderContentsForManagement") {
    getSingleFolderContentsForManagement();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "UploadFile") {
    UploadFile();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "addFolder") {
    addFolder();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "updateTagReference") {
    updateTagReference($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "togglePasteWithStyle") {
    togglePasteWithStyle();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "deleteFile") {
    deleteFile();
    //mysqli_close($conn);
    return;
}
if ($callFunction == "loadFolderFiles") {
    loadFolderFiles($_POST["path"], $_POST["type"]);
    //mysqli_close($conn);
    return;
}

if ($callFunction == "addPage") {
    addPage($conn);
    mysqli_close($conn);
    return;
}
echo "*error* Yükleme fonksiyonu bulunamadı!";
return;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function login($conn, $user, $pass)
{
    $sql =
        "SELECT * FROM users WHERE username='" .
        $user .
        "' AND password='" .
        md5($pass) .
        "'";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "Kullanıcı adı veya şifre yanlış";
        return;
    }

    $Row = mysqli_fetch_assoc($Result);

    if ($Row["usertype"] == "admin") {
        $_SESSION["admin"] = true;
    }

    $_SESSION["login"] = true;
    echo "ok";
}

function getPanelButtons()
{
    if (!isset($_SESSION["login"])) {
        echo "login";
        return;
    }

    if ($_SESSION["login"] != true) {
        echo "login";
        return;
    }

    echo "<div class=\"divPanelButton divSmall\" onclick=\"getPageList();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Sayfalar</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadImageManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Resimler</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadFileManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Dosyalar</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadGenericManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Generic</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadSubpageManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Subpage</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadListManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Liste</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\" onclick=\"LoadMetaManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Meta</span>";
    echo "</div>";

    echo "<div class=\"divPanelButton divSmall\"  onclick=\"LoadParameterManagement();\">";
    echo "<span class=\"spButtonIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spButton\">Parametre</span>";
    echo "</div>";
}

function getPageList($conn)
{
    if (!isset($_SESSION["login"])) {
        echo "<p>Oturum açılmamış!</p>";
        return;
    }
    if ($_SESSION["login"] != true) {
        echo "login";
        return;
    }

    $sqlPages = "SELECT * FROM pages ";
    $pagesResult = mysqli_query($conn, $sqlPages);

    if ($pagesResult == null || mysqli_num_rows($pagesResult) == 0) {
        echo "<p>Kayıtlı sayfa bulunamadı!</p>";
        return;
    }

    echo "<div onclick=\"AddPagePopup();\" class=\"divPage divPageAdd\" >";
    echo "<span class='spPageName'>+</span>";
    echo "</div>";

    $i = 1;
    while ($page = mysqli_fetch_assoc($pagesResult)) {
        echo "<div id=\"" .
            $page["id"] .
            "_page\" onclick=\"LoadPageContent(" .
            $page["id"] .
            "); \" class=\"divPage\" >";

        echo "<span class='spPageNo'>" . $i . "</span>";
        echo "<span class='spPageName'>" . $page["name"] . "</span>";

        echo "</div>";

        $i++;
    }
}

function getMetaPageList($conn)
{
    if (!isset($_SESSION["login"])) {
        echo "<p>Oturum açılmamış!</p>";
        return;
    }

    $sqlPages = "SELECT * FROM pages ";
    $pagesResult = mysqli_query($conn, $sqlPages);

    if ($pagesResult == null || mysqli_num_rows($pagesResult) == 0) {
        echo "<p>Kayıtlı sayfa bulunamadı!</p>";
        return;
    }

    $i = 1;
    while ($page = mysqli_fetch_assoc($pagesResult)) {
        echo "<div id=\"" .
            $page["id"] .
            "_page\" onclick=\"LoadPageMetaContent(" .
            $page["id"] .
            "); \" class=\"divPage\" >";

        echo "<span class='spPageNo'>" . $i . "</span>";
        echo "<span class='spPageName'>" . $page["name"] . "</span>";

        echo "</div>";

        $i++;
    }
}

function getPageContent($conn)
{
    $sqlTags =
        "SELECT * FROM tags WHERE pageid=" .
        $_POST["pageid"] .
        " ORDER BY sira";

    $tagsResult = mysqli_query($conn, $sqlTags);

    if ($tagsResult == null || mysqli_num_rows($tagsResult) == 0) {
        echo "<p>Kayıtlı eleman bulunamadı!</p>";
        return;
    }

    while ($tag = mysqli_fetch_assoc($tagsResult)) {
        echo "<div id=\"" .
            $tag["id"] .
            "_divTagName\" class=\"divTag\" onclick=\"LoadTagContent(" .
            $tag["id"] .
            ",'" .
            $tag["contenttype"] .
            "');\">";

        if (empty($tag["panelname"])) {
            echo "<span class=\"spTagName\">" . $tag["htmlid"] . "</span>";
        } else {
            echo "<span class=\"spTagName\">" . $tag["panelname"] . "</span>";
        }

        echo "<span class=\"spTagType\">" . $tag["contenttype"] . "</span>";

        echo "</div>";
    }
}

function getPageMetaContent()
{
    echo "<div  class=\"divTag\" onclick=\"LoadMetaContent(" .
        $_POST["pageid"] .
        ",'title');\">";

    echo "<span class=\"spTagName\">Sayfa Adı</span>";

    echo "</div>";

    echo "<div  class=\"divTag\" onclick=\"LoadMetaContent(" .
        $_POST["pageid"] .
        ",'description');\">";

    echo "<span class=\"spTagName\">Açıklama</span>";

    echo "</div>";

    echo "<div  class=\"divTag\" onclick=\"LoadMetaContent(" .
        $_POST["pageid"] .
        ",'keywords');\">";

    echo "<span class=\"spTagName\">Kelimeler</span>";

    echo "</div>";
    echo "<div  class=\"divTag\" onclick=\"LoadMetaContent(" .
        $_POST["pageid"] .
        ",'headlines');\">";

    echo "<span class=\"spTagName\">Başlıklar</span>";

    echo "</div>";
}

function getTagContent($conn)
{
    if ($_POST["tagType"] == "text") {
        $sqlGen =
            "SELECT name as language, content, texts.id
                   FROM texts
                   JOIN lang ON lang.id = texts.langid
                   WHERE tagid=" . $_POST["tagid"];

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        while ($textRow = mysqli_fetch_assoc($genResult)) {
            echo "<div class=\"divTagValue\">";

            echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                $textRow["language"] .
                "</span></div></div>";
            echo "<div class=\"divTagBtns\"><input type='button' value='Raw' onclick='convertToRaw(this);'>
                        <input type='button' value='Formatted' onclick='convertToFormatted(this);'></div>";

            $content = htmlspecialchars_decode($textRow["content"]);

            echo "<div id=\"" .
                $textRow["id"] .
                "_textid\" class=\"divTextValue\" contenteditable=\"true\" ";

            if ($_SESSION["PasteWithStyle"] == false) {
                echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
            }

            echo ">" . $content . "</div>";

            echo "</div>";
        }
    }

    if ($_POST["tagType"] == "value") {
        $sqlGen =
            "SELECT name as language, content, vals.id
                   FROM vals
                   JOIN lang ON lang.id = vals.langid
                   WHERE tagid=" . $_POST["tagid"];

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        while ($textRow = mysqli_fetch_assoc($genResult)) {
            echo "<div class=\"divTagValue\">";

            echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                $textRow["language"] .
                "</span></div> </div>";

            $content = htmlspecialchars_decode($textRow["content"]);

            echo "<div id=\"" .
                $textRow["id"] .
                "_valid\" class=\"divTextValue\" contenteditable=\"true\" ";

            if ($_SESSION["PasteWithStyle"] == false) {
                echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
            }

            echo ">" . $content . "</div>";

            echo "</div>";
        }
    }

    if ($_POST["tagType"] == "img") {
        echo "<div id=\"divFolderContainer\" class=\"divFolderContainer\">";

        $sqlGen =
            "SELECT value
                   FROM tagelements
                   WHERE parentid=" . $_POST["tagid"];

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        $imgRow = mysqli_fetch_assoc($genResult);
        $path = $imgRow["value"];

        if (strpos($path, "/") === false) {
            $files = scandir("../img");

            echo "<div class=\"divFolderContents\" >";
            echo "<h1>img</h1>";

            foreach ($files as $folder) {
                if ($folder == "Thumbs.db") {
                    continue;
                }

                if ($folder == "." || $folder == "..") {
                    continue;
                }

                if (is_dir("../img/" . $folder)) {
                    echo "<div class=\"divFolder\" onclick=\"selectFolder('" .
                        $folder .
                        "', this);\">";
                    echo "<span>" . $folder . "</span>";
                    echo "</div>";
                }
            }

            foreach ($files as $file) {
                if ($file == "Thumbs.db") {
                    continue;
                }

                if (!is_dir("../img/" . $file)) {
                    if ($path == $file) {
                        echo "<div class=\"divFileSelected\" onclick=\"selectFile(this);\">";
                    } else {
                        echo "<div class=\"divFile\" onclick=\"selectFile(this);\">";
                    }

                    echo "<span>" . $file . "</span>";
                    echo "</div>";
                }
            }

            echo "</div>"; //foldercontents
            return;
        }

        $valueFolderArr = explode("/", $path);

        $files = scandir("../img");

        echo "<div class=\"divFolderContents\" >";
        echo "<h1>img</h1>";

        foreach ($files as $folder) {
            if ($folder == "Thumbs.db") {
                continue;
            }

            if ($folder == "." || $folder == "..") {
                continue;
            }

            if (is_dir("../img/" . $folder)) {
                if ($valueFolderArr[0] == $folder) {
                    echo "<div class=\"divFolderSelected\" onclick=\"selectFolder('" .
                        $folder .
                        "', this);\">";
                } else {
                    echo "<div class=\"divFolder\" onclick=\"selectFolder('" .
                        $folder .
                        "', this);\">";
                }

                echo "<span>" . $folder . "</span>";
                echo "</div>";
            }
        }

        foreach ($files as $file) {
            if ($file == "Thumbs.db") {
                continue;
            }

            if (!is_dir("../img/" . $file)) {
                if ($path == $file) {
                    echo "<div class=\"divFileSelected\" onclick=\"selectFile(this);\">";
                } else {
                    echo "<div class=\"divFile\" onclick=\"selectFile(this);\">";
                }

                echo "<span>" . $file . "</span>";
                echo "</div>";
            }
        }

        echo "</div>"; //divFolderContents

        $folderCount = count($valueFolderArr);

        $folderString = "";

        for ($i = 0; $i < $folderCount - 1; $i++) {
            echo "<div class=\"divFolderContents\" >";
            echo "<h1>" . $valueFolderArr[$i] . "</h1>";

            $folderString .= "/" . $valueFolderArr[$i];

            if (is_dir("../img/" . $folderString)) {
                $files = scandir("../img" . $folderString);

                foreach ($files as $folder) {
                    if ($folder == "Thumbs.db") {
                        continue;
                    }

                    if ($folder == "." || $folder == "..") {
                        continue;
                    }

                    if (is_dir("../img" . $folderString . "/" . $folder)) {
                        if ($valueFolderArr[$i + 1] == $folder) {
                            echo "<div class=\"divFolderSelected\" onclick=\"selectFolder('" .
                                $folder .
                                "', this);\">";
                        } else {
                            echo "<div class=\"divFolder\" onclick=\"selectFolder('" .
                                $folder .
                                "', this);\">";
                        }

                        echo "<span>" . $folder . "</span>";
                        echo "</div>";
                    }
                }

                foreach ($files as $file) {
                    if ($file == "Thumbs.db") {
                        continue;
                    }

                    if (!is_dir("../img" . $folderString . "/" . $file)) {
                        if (
                            $i == $folderCount - 2 &&
                            $valueFolderArr[$i + 1] == $file
                        ) {
                            echo "<div class=\"divFileSelected\" onclick=\"selectFile(this);\">";
                        } else {
                            echo "<div class=\"divFile\" onclick=\"selectFile(this);\">";
                        }

                        echo "<span>" . $file . "</span>";
                        echo "</div>";
                    }
                }
            }

            echo "</div>";
        }

        echo "</div>";
    }

    if ($_POST["tagType"] == "generic") {
        $refid = "";

        $sqlRef =
            "SELECT referenceid
                  FROM tags
                  WHERE id=" . $_POST["tagid"];

        $refResult = mysqli_query($conn, $sqlRef);

        if ($refResult != null && mysqli_num_rows($refResult) != 0) {
            $refRow = mysqli_fetch_assoc($refResult);
            $refid = $refRow["referenceid"];
        }

        $sqlGen = "SELECT id, isim
                  FROM genericgroup
                  ";

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        while ($genRow = mysqli_fetch_assoc($genResult)) {
            echo "<div id=\"" . $genRow["id"] . "_ref\"";

            if ($genRow["id"] == $refid) {
                echo " class=\"divFolderSelected\" ";
            } else {
                echo " class=\"divFolder\" ";
            }

            echo "onclick=\"selectReferenceItem(this);\">";
            echo "<span>" . $genRow["isim"] . "</span>";
            echo "</div>";
        }
    }

    if ($_POST["tagType"] == "subpage") {
        $refid = "";

        $sqlRef =
            "SELECT referenceid
                  FROM tags
                  WHERE id=" . $_POST["tagid"];

        $refResult = mysqli_query($conn, $sqlRef);

        if ($refResult != null && mysqli_num_rows($refResult) != 0) {
            $refRow = mysqli_fetch_assoc($refResult);
            $refid = $refRow["referenceid"];
        }

        $sqlGen = "SELECT id, name
                  FROM subpage
                  ";

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        while ($genRow = mysqli_fetch_assoc($genResult)) {
            echo "<div id=\"" . $genRow["id"] . "_ref\"";

            if ($genRow["id"] == $refid) {
                echo " class=\"divFolderSelected\" ";
            } else {
                echo " class=\"divFolder\" ";
            }

            echo "onclick=\"selectReferenceItem(this);\">";
            echo "<span>" . $genRow["name"] . "</span>";
            echo "</div>";
        }
    }

    if ($_POST["tagType"] == "list") {
        $refid = "";

        $sqlRef =
            "SELECT referenceid
                  FROM tags
                  WHERE id=" . $_POST["tagid"];

        $refResult = mysqli_query($conn, $sqlRef);

        if ($refResult != null && mysqli_num_rows($refResult) != 0) {
            $refRow = mysqli_fetch_assoc($refResult);
            $refid = $refRow["referenceid"];
        }

        $sqlGen = "SELECT id, name
                  FROM lists
                  ";

        $genResult = mysqli_query($conn, $sqlGen);

        if ($genResult == null || mysqli_num_rows($genResult) == 0) {
            return;
        }

        while ($genRow = mysqli_fetch_assoc($genResult)) {
            echo "<div id=\"" . $genRow["id"] . "_ref\"";

            if ($genRow["id"] == $refid) {
                echo " class=\"divFolderSelected\" ";
            } else {
                echo " class=\"divFolder\" ";
            }

            echo "onclick=\"selectReferenceItem(this);\">";
            echo "<span>" . $genRow["name"] . "</span>";
            echo "</div>";
        }
    }
}

function getMetaContent($conn)
{
    $sqlGen =
        "SELECT name as language, type, value, meta.id
                   FROM meta
                   JOIN lang ON lang.id = meta.langid
                   WHERE pageid=" .
        $_POST["pageid"] .
        " AND type='" .
        $_POST["type"] .
        "'";

    $genResult = mysqli_query($conn, $sqlGen);

    if ($genResult == null || mysqli_num_rows($genResult) == 0) {
        return;
    }

    while ($textRow = mysqli_fetch_assoc($genResult)) {
        echo "<div class=\"divTagValue\">";

        echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
            $textRow["language"] .
            "</span></div> </div>";

        echo "<div id=\"" .
            $textRow["id"] .
            "_textid\" class=\"divTextValue\" contenteditable=\"true\" ";

        echo ">" . $textRow["value"] . "</div>";

        echo "</div>";
    }
}

function getSingleFolderContents()
{
    $files = scandir("../img/" . $_POST["path"]);

    echo "<div class=\"divFolderContents\" >";
    echo "<h1>" . $_POST["folder"] . "</h1>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        if (is_dir("../img/" . $_POST["path"] . "/" . $folder)) {
            echo "<div class=\"divFolder\" onclick=\"selectFolder('" .
                $folder .
                "',this);\">";
            echo "<span>" . $folder . "</span>";
            echo "</div>";
        }
    }

    foreach ($files as $file) {
        if ($file == "Thumbs.db") {
            continue;
        }

        if ($file == "." || $file == "..") {
            continue;
        }

        if (!is_dir("../img/" . $_POST["path"] . "/" . $file)) {
            echo "<div class=\"divFile\" onclick=\"selectFile(this);\">";
            echo "<span>" . $file . "</span>";
            echo "</div>";
        }
    }

    echo "</div>"; //foldercontents
}

function saveTextContent($conn)
{
    $value = str_replace("'", "''", $_POST["textVal"]);
    //$value=str_replace("+","_lt;" , $_POST["textVal"] );

    $sqlSave =
        "UPDATE texts SET content='" .
        htmlspecialchars_decode($value) .
        "' WHERE id=" .
        $_POST["textid"];

    if (!mysqli_query($conn, $sqlSave)) {
        echo "*error* Text alanı güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function saveMetaContent($conn)
{
    $value = str_replace("'", "''", $_POST["value"]);

    $sqlSave =
        "UPDATE meta SET value='" . $value . "' WHERE id=" . $_POST["metaid"];

    if (!mysqli_query($conn, $sqlSave)) {
        echo "*error* Meta alanı güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function saveValueContent($conn)
{
    $value = str_replace("'", "''", $_POST["value"]);

    $sqlSave =
        "UPDATE vals SET content='" .
        htmlspecialchars_decode($value) .
        "' WHERE id=" .
        $_POST["valid"];

    if (!mysqli_query($conn, $sqlSave)) {
        echo "*error* Değer güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function saveImgValue($conn)
{
    $sqlSave =
        "UPDATE tagelements SET value='" .
        $_POST["value"] .
        "' WHERE type='img' AND parentid=" .
        $_POST["tagid"];

    if (!mysqli_query($conn, $sqlSave)) {
        echo "*error* Img değeri güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function getImageManagement()
{
    echo "<div id=\"divFolderContainer\" class=\"divFolderContainer\">";

    $files = scandir("../img");

    echo "<div class=\"divFolderContents\" >";
    echo "<h1>img</h1>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        if (is_dir("../img/" . $folder)) {
            echo "<div class=\"divFolder\" onclick=\"selectFolderForManagement('img/','" .
                $folder .
                "', this);\">";
            echo "<span>" . $folder . "</span>";
            echo "</div>";
        }
    }

    echo "<div class='divAddFolder'>";
    echo "<div class=\"divAddFolderBtn\" onclick=\"addFolderPop('img/','/');\">";
    echo "<span class=\"spAddFolderIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spAddFolder\">Ekle</span>";
    echo "</div>";
    echo "</div>";

    echo "</div>"; //foldercontents

    echo "</div>"; //divFolderContainer

    echo "<div class=\"divUpload\">";

    echo "<p id='pPath'></p>";

    echo "<input type=\"file\" id=\"fileUpload\" /> &nbsp;&nbsp;&nbsp; <input type=\"button\" value=\"Gönder\" onclick=\"UploadFile();\" />";

    echo "<p id='pUploadResult'></p>";

    echo "</div>";

    echo "<div id=\"divFiles\">";

    loadFolderFiles("img/", "image");

    echo "</div>";
}

function loadFolderFiles($path, $type)
{
    $files = scandir("../" . $path);

    foreach ($files as $file) {
        if ($file == "Thumbs.db") {
            continue;
        }

        if ($file == "." || $file == "..") {
            continue;
        }

        if (is_dir("../" . $path . $file)) {
            continue;
        }

        echo "<div class=\"divFileRow\">";

        if ($type == "image") {
            echo "<img src='../" . $path . $file . "'>";
        }

        if ($type == "file") {
            echo "<img src='../img/icon_file.png' style='width: 1.5em'>";
        }

        echo "<span>" .
            $file .
            "</span>  
              <div class='divFileDelete' onclick='fileDeleteConfirm(\"" .
            $file .
            "\");'>SİL</div>
              </div>";
    }
}

function getFileManagement()
{
    echo "<div id=\"divFolderContainer\" class=\"divFolderContainer\">";

    $files = scandir("../files");

    echo "<div class=\"divFolderContents\" >";
    echo "<h1>files</h1>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        if (is_dir("../files/" . $folder)) {
            echo "<div class=\"divFolder\" onclick=\"selectFolderForManagement('files/','" .
                $folder .
                "', this);\">";
            echo "<span>" . $folder . "</span>";
            echo "</div>";
        }
    }

    echo "<div class='divAddFolder'>";
    echo "<div class=\"divAddFolderBtn\" onclick=\"addFolderPop('files/','/');\">";
    echo "<span class=\"spAddFolderIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spAddFolder\">Ekle</span>";
    echo "</div>";
    echo "</div>";

    echo "</div>"; //foldercontents

    echo "</div>"; //divFolderContainer

    echo "<div class=\"divUpload\">";

    echo "<p id='pPath'></p>";

    echo "<input type=\"file\" id=\"fileUpload\" /> &nbsp;&nbsp;&nbsp; <input type=\"button\" value=\"Gönder\" onclick=\"UploadFile();\" />";

    echo "<p id='pUploadResult'></p>";

    echo "</div>";

    echo "<div id=\"divFiles\">";

    loadFolderFiles("files/", "file");

    echo "</div>";
}

function getSingleFolderContentsForManagement()
{
    $files = scandir("../" . $_POST["root"] . $_POST["path"]);

    echo "<div class=\"divFolderContents\" >";
    echo "<h1>" . $_POST["folder"] . "</h1>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        if (is_dir("../" . $_POST["root"] . $_POST["path"] . "/" . $folder)) {
            echo "<div class=\"divFolder\" onclick=\"selectFolderForManagement('" .
                $_POST["root"] .
                "','" .
                $folder .
                "',this);\">";
            echo "<span>" . $folder . "</span>";
            echo "</div>";
        }
    }

    echo "<div class='divAddFolder'>";
    echo "<div class=\"divAddFolderBtn\" onclick=\"addFolderPop('" .
        $_POST["root"] .
        "','" .
        $_POST["path"] .
        "');\">";
    echo "<span class=\"spAddFolderIcon icon_menu-circle_alt2\"></span>";
    echo "<span class=\"spAddFolder\">Ekle</span>";
    echo "</div>";
    echo "</div>";

    echo "</div>"; //foldercontents
}

function UploadFile()
{
    //dosya yükleme hatası verirse hosting panelinden klasöre yazma izni verilmesi gerekiyor.
    if (!isset($_SESSION["login"])) {
        return;
    }
    if ($_SESSION["login"] != true) {
        return;
    }

    $result = move_uploaded_file(
        $_FILES["file"]["tmp_name"],
        "../" . $_POST["path"]
    );
    if ($result) {
        echo "ok";
    } else {
        echo "*error* Resim yüklenemedi. #" . $_FILES["file"]["error"];
    }
}

function addFolder()
{
    $path = $_POST["path"];

    if (strpos($path, $_POST["root"]) === 0) {
        $path = "../" . $path;
    } else {
        $path = "../" . $_POST["root"] . $path;
    }

    if (!file_exists($path . $_POST["folder"])) {
        if (mkdir($path . $_POST["folder"], 0777, true)) {
            echo "ok";
            return;
        }
    } else {
        echo "Klasör zaten mevcut!";
        return;
    }

    echo "Klasör yaratılırken sorun oluştu!";
}

function updateTagReference($conn)
{
    $sqlSave =
        "UPDATE tags SET referenceid='" .
        $_POST["referenceid"] .
        "' WHERE id=" .
        $_POST["tagid"];

    if (!mysqli_query($conn, $sqlSave)) {
        echo "*error* Referans alanı güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function togglePasteWithStyle()
{
    if ($_SESSION["PasteWithStyle"] == true) {
        $_SESSION["PasteWithStyle"] = false;
        echo "Kapalı";
    } else {
        $_SESSION["PasteWithStyle"] = true;
        echo "Açık";
    }
}

function deleteFile()
{
    $file = "../" . $_POST["path"] . $_POST["fileName"];

    if (!unlink($file)) {
        echo "Dosya silinirken hata oluştu";
    } else {
        echo "ok";
    }
}

function addPage($conn)
{
    $sqlInsert =
        "INSERT INTO pages (name,file)
                    VALUES ('" .
        $_POST["pageName"] .
        "','" .
        $_POST["pageDB"] .
        "')";

    if (mysqli_query($conn, $sqlInsert)) {
        $pageid = mysqli_insert_id($conn);
        InsertMetaRows($pageid, $conn);

        echo "ok";
    } else {
        echo "*error* Sayfa eklenirken hata oluştu!";
    }
}

function InsertMetaRows($pageid, $conn)
{
    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        return "<p>Kayıtlı dil bulunamadı!</p>";
    }

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sql =
            "INSERT INTO meta (pageid,langid,type) VALUES (" .
            $pageid .
            "," .
            $langRow["id"] .
            ",'title')";

        if (!mysqli_query($conn, $sql)) {
            return "Meta eklenirken hata oluştu! (sql)";
        }
    }

    mysqli_data_seek($langResult, 0);

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sql =
            "INSERT INTO meta (pageid,langid,type) VALUES (" .
            $pageid .
            "," .
            $langRow["id"] .
            ",'description')";

        if (!mysqli_query($conn, $sql)) {
            return "Meta eklenirken hata oluştu! (sql)";
        }
    }

    mysqli_data_seek($langResult, 0);

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sql =
            "INSERT INTO meta (pageid,langid,type) VALUES (" .
            $pageid .
            "," .
            $langRow["id"] .
            ",'keywords')";

        if (!mysqli_query($conn, $sql)) {
            return "Meta eklenirken hata oluştu! (sql)";
        }
    }

    mysqli_data_seek($langResult, 0);

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sql =
            "INSERT INTO meta (pageid,langid,type) VALUES (" .
            $pageid .
            "," .
            $langRow["id"] .
            ",'headlines')";

        if (!mysqli_query($conn, $sql)) {
            return "Meta eklenirken hata oluştu! (sql)";
        }
    }

    return "ok";
}
