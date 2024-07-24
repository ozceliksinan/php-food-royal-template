<?php
//session_start();
include "Genel.php";

$GLOBALS["connection"] = $conn;

function getLangCode()
{
    $langCode = "en";

    if ($_SESSION["Langid"] == 1) {
        $langCode = "tr";
    }

    if ($_SESSION["Langid"] == 2) {
        $langCode = "en";
    }

    echo "\"" . $langCode . "\"";
}

function getPageTitle($pageName)
{
    $sqlContent =
        "SELECT value FROM meta WHERE type='title' AND langid=" .
        $_SESSION["Langid"] .
        " AND pageid=(SELECT id FROM pages WHERE file='" .
        $pageName .
        "')";

    $contentResult = mysqli_query($GLOBALS["connection"], $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        //echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);

    echo $contentRow["value"];
}

function getDescription($pageName)
{
    $sqlContent =
        "SELECT value FROM meta WHERE type='description' AND langid=" .
        $_SESSION["Langid"] .
        " AND pageid=(SELECT id FROM pages WHERE file='" .
        $pageName .
        "')";

    $contentResult = mysqli_query($GLOBALS["connection"], $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        //echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);

    echo "\"" . $contentRow["value"] . "\"";
}
function getKeywords($pageName)
{
    $sqlContent =
        "SELECT value FROM meta WHERE type='keywords' AND langid=" .
        $_SESSION["Langid"] .
        " AND pageid=(SELECT id FROM pages WHERE file='" .
        $pageName .
        "')";

    $contentResult = mysqli_query($GLOBALS["connection"], $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        //echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);

    echo "\"" . $contentRow["value"] . "\"";
}

function getHeadlines($pageName)
{
    $sqlContent =
        "SELECT value FROM meta WHERE type='headlines' AND langid=" .
        $_SESSION["Langid"] .
        " AND pageid=(SELECT id FROM pages WHERE file='" .
        $pageName .
        "')";

    $contentResult = mysqli_query($GLOBALS["connection"], $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        //echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);

    $headlinesArr = explode(",", $contentRow["value"]);

    echo "<div class=\"divHeadlines\">";

    for ($i = 0; $i < count($headlinesArr); $i++) {
        echo "<div><h1>" . $headlinesArr[$i] . "</h1></div> ";
    }

    echo "</div>";
}
