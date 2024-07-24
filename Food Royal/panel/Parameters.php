<?php

include "PanelGenel.php";

if (empty($_POST["call"])) {
    echo "*error* Yükleme fonksiyonu alınamadı!";
    return;
}
$callFunction = $_POST["call"];

if ($callFunction == "loadTagParameters") {
    loadTagParameters($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "addParameter") {
    addParameter($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "saveTagParameters") {
    saveTagParameters($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "checkParamHasVal") {
    checkParamHasVal($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreYukle") {
    baseTagParametreYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericTagParametreYukle") {
    genericTagParametreYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreKaydet") {
    baseTagParametreKaydet($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericTagParametreKaydet") {
    genericTagParametreKaydet($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreTumuneUygula") {
    baseTagParametreTumuneUygula($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "SaveGenericParameter") {
    SaveGenericParameter($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "LoadGenericParams") {
    LoadGenericParameters($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "SubpageTagParametreYukle") {
    SubpageTagParametreYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "SubpageTagParametreKaydet") {
    SubpageTagParametreKaydet($conn);
    mysqli_close($conn);
    return;
}

echo "*error* Yükleme fonksiyonu bulunamadı!";
return;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function loadTagParameters($conn)
{
    $sqlSelect = "SELECT * FROM tags WHERE id=" . $_POST["tagid"];
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    if (empty($selectRow["parameter"])) {
        return;
    }

    $paramsArr = explode("|", $selectRow["parameter"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        $paramArr = explode("=", $paramsArr[$i]);

        $value = null;
        if (count($paramArr) > 0) {
            $value = $paramArr[1];
        }

        echo getParameterDiv($paramArr[0], $value, $conn);
    }
}

function getParameterDiv($type, $value, $conn)
{
    $divString = '<div class="divParameter">';

    $divString .= getParameterSelect($type, $conn);

    if (isset($value)) {
        $divString .= '<input type="text" value="' . $value . '" />';
    }

    $divString .=
        '<input type="button" value="Sil" onclick="removeParameterDiv(this);" />';

    $divString .= "</div>";

    return $divString;
}

function getParameterSelect($type, $conn)
{
    $sqlSelect = "SELECT * FROM parametertype";
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        $selectString = "<select></select>";
        return $selectString;
    }

    $selectString = '<select onchange="checkParamHasVal(this);">';
    $selectString .= "<option></option>";
    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($type) || $type != $selectRow["name"]) {
            $selectString .= "<option>" . $selectRow["name"] . "</option>";
        } else {
            $selectString .=
                "<option selected=\"selected\">" .
                $selectRow["name"] .
                "</option>";
        }
    }

    $selectString .= "</select>";

    return $selectString;
}

function addParameter($conn)
{
    echo getParameterDiv("", "", $conn);
}

function checkParamHasVal($conn)
{
    $sqlSelect =
        "SELECT hasVal FROM parametertype WHERE name='" . $_POST["val"] . "'";
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        echo "1";
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    echo $selectRow["hasVal"];
}

function checkParamHasValBool($param, $conn)
{
    $sqlSelect = "SELECT hasVal FROM parametertype WHERE name='" . $param . "'";
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return true;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    $result = false;

    if ($selectRow["hasVal"] == "1") {
        $result = true;
    }

    return $result;
}

function saveTagParameters($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    $sql =
        "UPDATE tags SET parameter = '" .
        $parameter .
        "' WHERE id=" .
        $_POST["tagid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Parametre güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function baseTagParametreYukle($conn)
{
    $sqlSelect = "SELECT * FROM genericbase WHERE id=" . $_POST["baseid"];
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    if (empty($selectRow["parameter"])) {
        return;
    }

    $paramsArr = explode("|", $selectRow["parameter"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        $paramArr = explode("=", $paramsArr[$i]);

        $value = null;
        if (checkParamHasValBool($paramArr[0], $conn)) {
            $value = "";
        }

        if (count($paramArr) > 1) {
            $value = $paramArr[1];
        }

        echo getParameterDiv($paramArr[0], $value, $conn);
    }
}

function genericTagParametreYukle($conn)
{
    $sqlSelect = "SELECT * FROM tagelements WHERE id=" . $_POST["genid"];
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    if (empty($selectRow["parameter"])) {
        return;
    }

    $paramsArr = explode("|", $selectRow["parameter"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        $paramArr = explode("=", $paramsArr[$i]);

        $value = null;
        if (checkParamHasValBool($paramArr[0], $conn)) {
            $value = "";
        }

        if (count($paramArr) > 1) {
            $value = $paramArr[1];
        }

        echo getParameterDiv($paramArr[0], $value, $conn);
    }
}

function baseTagParametreKaydet($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    $sql =
        "UPDATE genericbase SET parameter = '" .
        $parameter .
        "' WHERE id=" .
        $_POST["baseid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Parametre güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function genericTagParametreKaydet($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    if ($_POST["langid"] == "0") {
        $sql =
            "UPDATE tagelements SET parameter = '" .
            $parameter .
            "' WHERE id=" .
            $_POST["id"];

        if (!mysqli_query($conn, $sql)) {
            echo "*error* Parametre güncellenirken hata oluştu!";
            return;
        }
    } else {
        $sql =
            "UPDATE tagelements SET parameter = '" .
            $parameter .
            "' WHERE parentid=" .
            $_POST["parentid"] .
            " AND baseid= " .
            $_POST["baseid"];

        if (!mysqli_query($conn, $sql)) {
            echo "*error* Parametre güncellenirken hata oluştu!";
            return;
        }
    }

    echo "ok";
}

function baseTagParametreTumuneUygula($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    $sql =
        "UPDATE tagelements SET parameter = '" .
        $parameter .
        "' WHERE baseid=" .
        $_POST["baseid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Parametreler güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function SaveGenericParameter($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    if ($_POST["type"] == "generic") {
        $sql =
            "UPDATE generic SET parametre = '" .
            $parameter .
            "' WHERE id=" .
            $_POST["id"];
    } elseif ($_POST["type"] == "tagelements") {
        $sql =
            "UPDATE tagelements SET parameter = '" .
            $parameter .
            "' WHERE id=" .
            $_POST["id"];
    }

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Parametre güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function LoadGenericParameters($conn)
{
    if ($_POST["type"] == "generic") {
        $sqlSelect = "SELECT * FROM generic WHERE id=" . $_POST["id"];
    } elseif ($_POST["type"] == "tagelements") {
        $sqlSelect = "SELECT * FROM tagelements WHERE id=" . $_POST["id"];
    }

    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    if (empty($selectRow["parametre"])) {
        return;
    }

    $paramsArr = explode("|", $selectRow["parametre"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        $paramArr = explode("=", $paramsArr[$i]);

        $value = null;
        if (checkParamHasValBool($paramArr[0], $conn)) {
            $value = "";
        }

        if (count($paramArr) > 1) {
            $value = $paramArr[1];
        }

        echo getParameterDiv($paramArr[0], $value, $conn);
    }
}

function SubpageTagParametreYukle($conn)
{
    $sqlSelect = "SELECT * FROM subpagetags WHERE id=" . $_POST["tagid"];
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectRow = mysqli_fetch_assoc($selectResult);

    if (empty($selectRow["parameter"])) {
        return;
    }

    $paramsArr = explode("|", $selectRow["parameter"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        $paramArr = explode("=", $paramsArr[$i]);

        $value = null;
        if (checkParamHasValBool($paramArr[0], $conn)) {
            $value = "";
        }

        if (count($paramArr) > 1) {
            $value = $paramArr[1];
        }

        echo getParameterDiv($paramArr[0], $value, $conn);
    }
}

function SubpageTagParametreKaydet($conn)
{
    $parameter = str_replace("'", "''", $_POST["parameter"]);

    $sql =
        "UPDATE subpagetags SET parameter = '" .
        $parameter .
        "' WHERE subpageid=" .
        $_POST["subpageid"] .
        " AND taggroupcode= " .
        $_POST["groupcode"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Parametre güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}
