<?php
//session_start();
include "Genel.php";

$Htmlid = $_POST["Htmlid"];
$TagName = $_POST["TagName"];
$TagType = $_POST["TagType"];

$contentType = getContentType($TagName, $TagType);

if ($contentType == "error") {
    echo "Kayıt eklenirken hata oluştu! (contenttype)";
    return;
}

$sql =
    "INSERT INTO tags (htmlid,tagname,contenttype) VALUES ('" .
    $Htmlid .
    "','" .
    $TagName .
    "','" .
    $contentType .
    "')";

if (mysqli_query($conn, $sql)) {
    InsertContentRows(mysqli_insert_id($conn), $contentType, $conn);
} else {
    if (strpos(mysqli_error($conn), "Duplicate entry") !== false) {
        echo "ok";
    } else {
        echo "Kayıt eklenirken hata oluştu! (sql)";
    }
}
mysqli_close($conn);

function getContentType($tagname, $tagtype)
{
    if ($tagtype == "module") {
        return "module";
    }
    if ($tagtype == "generic") {
        return "generic";
    }
    if ($tagtype == "subpage") {
        return "subpage";
    }
    if ($tagtype == "list") {
        return "list";
    }
    if (
        $tagname == "DIV" ||
        $tagname == "SECTION" ||
        $tagname == "H1" ||
        $tagname == "H2" ||
        $tagname == "H3" ||
        $tagname == "P" ||
        $tagname == "LABEL" ||
        $tagname == "SPAN"
    ) {
        return "text";
    }
    if ($tagname == "INPUT") {
        return "value";
    }
    if ($tagname == "IMG") {
        return "img";
    }
    if ($tagname == "TEXTAREA") {
        return "value";
    }

    return "error";
}

function InsertContentRows($tagid, $contentType, $conn)
{
    if (
        $contentType == "module" ||
        $contentType == "generic" ||
        $contentType == "subpage" ||
        $contentType == "list"
    ) {
        echo "ok";
        return;
    }

    if ($contentType == "img") {
        InsertImg($tagid, $conn);
        return;
    }

    if ($contentType == "text") {
        $tableName = "texts";
    }

    if ($contentType == "value") {
        $tableName = "vals";
    }

    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        echo "<p>Kayıtlı dil bulunamadı!</p>";
        return;
    }

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sql =
            "INSERT INTO " .
            $tableName .
            " (langid,tagid) VALUES (" .
            $langRow["id"] .
            ",'" .
            $tagid .
            "')";

        if (!mysqli_query($conn, $sql)) {
            echo "Content eklenirken hata oluştu! (sql)";
            return;
        }
    }

    echo "ok";
}

function InsertImg($tagid, $conn)
{
    $sql =
        "INSERT INTO tagelements (langid,parentid,type,sira) VALUES (0,'" .
        $tagid .
        "','img',0)";

    if (!mysqli_query($conn, $sql)) {
        echo "Image eklenirken hata oluştu! (sql)";
        return;
    }

    echo "ok";
}
