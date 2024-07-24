<?php

include "PanelGenel.php";

if (empty($_POST["call"])) {
    echo "*error* Yükleme fonksiyonu alınamadı!";
    return;
}
$callFunction = $_POST["call"];

if ($callFunction == "GetSubpageManager") {
    GetSubpageManager($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "LoadSubpageTags") {
    LoadSubpageTags($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "DeleteSubpage") {
    DeleteSubpage($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "AddSubpage") {
    AddSubpage($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "AddSubpageTag") {
    AddSubpageTag($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "SaveSubpageTags") {
    SaveSubpageTags($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "DeleteSubpageTag") {
    DeleteSubpageTag($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "AddSubpageChild") {
    AddSubpageChild($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "LoadTagTypeField") {
    LoadTagTypeField($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getTypeValueSelect") {
    getTypeValueSelect(null, null, null, null, null, $conn);
    mysqli_close($conn);
    return;
}

echo "*error* Yükleme fonksiyonu bulunamadı!";
return;

function GetSubpageManager($conn)
{
    $sql = "SELECT * FROM subpage";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<p>Subpage bulunamadı!</p>";
    }

    echo "<div id=\"divSubpageUst\" style=\"border:dotted; padding:1em;\">";

    echo "<select id=\"selSubpage\" onchange=\"LoadSubpageTags();\">";

    echo "<option></option>";

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo "<option value=\"" .
            $Row["id"] .
            "\">" .
            $Row["name"] .
            "</option>";
    }

    echo "</select> <input type=\"button\" value=\"Sil\" onclick=\"DeleteSubpage();\" />";
    //echo "<label>Dil:</label>".getLanguageSelectSubpage($conn);
    //echo "<input type=\"button\" value=\"Yükle\" onclick=\"LoadSubpageTags();\" />";
    echo "<br /><br />";

    echo "<input id=\"txtSubpageName\" type=\"text\" placeholder=\"Yeni Subpage\" /> <input type=\"button\" value=\"Subpage Ekle\" onclick=\"AddSubpage();\" />";

    /*echo "<div id=\"divSubpageTags\" style=\"border:dotted; padding:1em;\">
			<input type=\"button\" value=\"Ekle\" onclick=\"AddSubpageTag();\" />
		  </div>";*/

    echo "</div>";

    echo "<div id=\"divSubpageAlt\" style=\"border:dotted; padding:1em;\">";
    echo "</div>";
}

function LoadTagTypeField($connection)
{
    $subpagetagid = $_POST["subpagetagid"];
    $value = $_POST["value"];

    if ($value == "1") {
        //normal
        echo "<input type=\"text\" value=\"" . $value . "\" />";
        echo "<input id=\"" . $subpagetagid . "_tag\" type=\"text\" />";
    }

    if ($value == "2") {
        //generic
        echo getTagGenericGroupList($subpagetagid, $value, $connection);
    }

    if ($value == "4") {
        //list
        echo getSubpageListSelect($subpagetagid, $value, $connection);
        echo "<input id=\"" . $subpagetagid . "_tag\" type=\"text\" />";
    }
}

function LoadSubpageTags($conn)
{
    $subpageid = $_POST["subpageid"];
    //$langid = $_POST["langid"];

    $sql =
        "SELECT * FROM subpagetags WHERE parentid=0 AND langid=1 AND subpageid=" .
        $subpageid;
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<p>Subpage Tag bulunamadı!</p>";
        //return;	kaydet butonu çıkmıyor
    }

    //KOLON BAŞLIKLARI
    echo "<div style=\" text-align: center; \"> <label>Name</label>
					        <label>&nbsp;&nbsp;&nbsp;&nbsp;Type</label>
							<label>&nbsp;&nbsp;&nbsp;&nbsp;Type Value</label>
							<label>&nbsp;&nbsp;&nbsp;&nbsp;Tag</label>";

    $sqlLang = "SELECT * FROM lang";
    $ResultLang = mysqli_query($conn, $sqlLang);

    if ($ResultLang == null || mysqli_num_rows($ResultLang) == 0) {
    }

    while ($RowLang = mysqli_fetch_assoc($ResultLang)) {
        echo "<label>&nbsp;&nbsp;&nbsp;&nbsp;" . $RowLang["name"] . "</label>";
    }

    echo "</div>";

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo "<div id=\"" .
            $Row["id"] .
            "_div_" .
            $Row["taggroupcode"] .
            "\" class=\"divNormal\" onclick=\"divSelected(this);\">";

        echo "<input id=\"" .
            $Row["id"] .
            "_name_" .
            $Row["taggroupcode"] .
            "\" type=\"text\" value=\"" .
            $Row["name"] .
            "\" />";

        $parents = $Row["id"];

        echo getSubpageTagTypeList(
            $Row["type"],
            $Row["id"],
            $Row["taggroupcode"],
            $conn
        );

        getTypeValueSelect(
            $Row["type"],
            $Row["id"],
            $Row["subpageid"],
            $Row["taggroupcode"],
            $Row["value"],
            $conn
        );

        //echo "<span id=\"".$Row["id"]."_valuespan\" style=\"display:inline-block;\" >";

        echo "<input id=\"" .
            $Row["id"] .
            "_tag_" .
            $Row["taggroupcode"] .
            "\" type=\"text\" value=\"" .
            $Row["tag"] .
            "\" />";

        //if($Row["type"]=="1") //normal
        //{

        echo "<input id=\"" .
            $Row["id"] .
            "_value_" .
            $Row["taggroupcode"] .
            "_1\" type=\"text\" ";

        if ($Row["type"] == "1") {
            echo "value=\"" . $Row["value"] . "\" ";
        } else {
            echo "disabled";
        }

        echo " />";

        $sqlLang = "SELECT * FROM lang WHERE id>1";
        $ResultLang = mysqli_query($conn, $sqlLang);

        if ($ResultLang == null || mysqli_num_rows($ResultLang) == 0) {
        }

        while ($RowLang = mysqli_fetch_assoc($ResultLang)) {
            $sqlLangValue =
                "SELECT * FROM subpagetags WHERE langid=" .
                $RowLang["id"] .
                " AND taggroupcode=" .
                $Row["taggroupcode"] .
                " AND subpageid=" .
                $subpageid;
            $ResultLangValue = mysqli_query($conn, $sqlLangValue);

            if (
                $ResultLangValue == null ||
                mysqli_num_rows($ResultLangValue) == 0
            ) {
            }

            $RowLangValue = mysqli_fetch_assoc($ResultLangValue);

            echo "<input id=\"" .
                $RowLangValue["id"] .
                "_value_" .
                $Row["taggroupcode"] .
                "_" .
                $RowLang["id"] .
                "\" type=\"text\" ";

            if ($Row["type"] == "1") {
                echo "value=\"" . $RowLangValue["value"] . "\" ";
            } else {
                echo "disabled";
            }

            echo " />";

            $parents .= "_" . $RowLangValue["id"];
        }

        echo "<input type=\"button\" value=\"+\" onclick=\"AddSubpageChild('" .
            $parents .
            "'," .
            $subpageid .
            ");\" />";
        echo "<input type=\"button\" value=\"x\" onclick=\"DeleteSubpageTag(" .
            $Row["id"] .
            "," .
            $Row["taggroupcode"] .
            "," .
            $subpageid .
            ");\" />";

        //}

        /*if($Row["type"]=="2") //generic
			echo getTagGenericGroupList($Row["id"],$Row["value"],$conn);
		if($Row["type"]=="3") //module
			echo getTagGenericGroupList(0,0,$conn);//burada value alanı alınacak, fonksiyona gönderilecek modül listesinde seçili olan value olacak
		if($Row["type"]=="4") //list
		{
			echo getSubpageListSelect($Row["id"],$Row["value"],$conn);
			//echo "<input id=\"".$Row["id"]."_tag\" type=\"text\" value=\"".$Row["tag"]."\" />";
		}*/

        //echo "</span>";

        echo "<br />";

        echo "</div>";

        getChildTags($Row["id"], 1, $conn);
    }

    echo "<input type=\"button\" value=\"Ekle\" onclick=\"AddSubpageTag(" .
        $subpageid .
        ");\" />";
    echo "<input type=\"button\" value=\"Kaydet\" onclick=\"SaveSubpageTags(" .
        $subpageid .
        ");\" /><label id=\"lblcounter\">0</label>";
}

function getChildTags($parentid, $offset, $conn)
{
    $sqlChild =
        "SELECT * FROM subpagetags WHERE langid=1 AND parentid=" . $parentid;
    $Result = mysqli_query($conn, $sqlChild);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($childRow = mysqli_fetch_assoc($Result)) {
        //echo "<br />";

        echo "<div id=\"" .
            $childRow["id"] .
            "_div_" .
            $childRow["taggroupcode"] .
            "\" class=\"divNormal\" onclick=\"divSelected(this);\">";

        for ($i = 0; $i < $offset; $i++) {
            echo "&nbsp;-&nbsp;";
        }

        echo "<input id=\"" .
            $childRow["id"] .
            "_name_" .
            $childRow["taggroupcode"] .
            "\" type=\"text\" value=\"" .
            $childRow["name"] .
            "\" />";

        $parents = $childRow["id"];

        //echo "<input type=\"text\" value=\"".$childRow["type"]."\" />";
        echo getSubpageTagTypeList(
            $childRow["type"],
            $childRow["id"],
            $childRow["taggroupcode"],
            $conn
        );

        getTypeValueSelect(
            $childRow["type"],
            $childRow["id"],
            $childRow["subpageid"],
            $childRow["taggroupcode"],
            $childRow["value"],
            $conn
        );

        //echo "<span id=\"".$childRow["id"]."_valuespan\" style=\"display:inline-block;\" >";

        echo "<input id=\"" .
            $childRow["id"] .
            "_tag_" .
            $childRow["taggroupcode"] .
            "\" type=\"text\" value=\"" .
            $childRow["tag"] .
            "\" />";

        //if($childRow["type"]=="1") //normal
        //{
        echo "<input id=\"" .
            $childRow["id"] .
            "_value_" .
            $childRow["taggroupcode"] .
            "_1\" type=\"text\" ";

        if ($childRow["type"] == "1") {
            echo "value=\"" . $childRow["value"] . "\" ";
        } else {
            echo "disabled";
        }

        echo " />";

        $sqlLang = "SELECT * FROM lang WHERE id>1";
        $ResultLang = mysqli_query($conn, $sqlLang);

        if ($ResultLang == null || mysqli_num_rows($ResultLang) == 0) {
        }

        while ($RowLang = mysqli_fetch_assoc($ResultLang)) {
            $sqlLangValue =
                "SELECT * FROM subpagetags WHERE langid=" .
                $RowLang["id"] .
                " AND taggroupcode=" .
                $childRow["taggroupcode"] .
                " AND subpageid=" .
                $childRow["subpageid"];
            $ResultLangValue = mysqli_query($conn, $sqlLangValue);

            if (
                $ResultLangValue == null ||
                mysqli_num_rows($ResultLangValue) == 0
            ) {
            }

            $RowLangValue = mysqli_fetch_assoc($ResultLangValue);

            echo "<input id=\"" .
                $RowLangValue["id"] .
                "_value_" .
                $childRow["taggroupcode"] .
                "_" .
                $RowLang["id"] .
                "\" type=\"text\" ";

            if ($childRow["type"] == "1") {
                echo "value=\"" . $RowLangValue["value"] . "\" ";
            } else {
                echo "disabled";
            }

            echo " />";

            $parents .= "_" . $RowLangValue["id"];
        }

        //}

        echo "<input type=\"button\" value=\"+\" onclick=\"AddSubpageChild('" .
            $parents .
            "'," .
            $childRow["subpageid"] .
            ");\" />";
        echo "<input type=\"button\" value=\"x\" onclick=\"DeleteSubpageTag(" .
            $childRow["id"] .
            "," .
            $childRow["taggroupcode"] .
            "," .
            $childRow["subpageid"] .
            ");\" />";

        /*if($childRow["type"]=="2") //generic
			echo getTagGenericGroupList($childRow["id"],$childRow["value"],$conn);
		if($childRow["type"]=="3") //module
			echo getTagGenericGroupList(0,0,$conn);//burada value alanı alınacak, fonksiyona gönderilecek modül listesinde seçili olan value olacak
		if($childRow["type"]=="4") //list
		{
			echo getSubpageListSelect($childRow["id"],$childRow["value"],$conn);
			//echo "<input id=\"".$childRow["id"]."_tag\" type=\"text\" value=\"".$childRow["tag"]."\" />";
		}*/

        //echo "</span>";

        //echo "<br />";

        echo "</div>";

        getChildTags($childRow["id"], $offset + 1, $conn);
    }
}

function AddSubpage($conn)
{
    $sqlInsert =
        "INSERT INTO subpage (name) VALUES ('" . $_POST["subpageName"] . "')";

    if (mysqli_query($conn, $sqlInsert)) {
        echo "ok";
    } else {
        echo "*error* Subpage eklenirken hata oluştu!";
    }
}

function AddSubpageTag($conn)
{
    $sqlMaxCode =
        "SELECT MAX(taggroupcode) maxCode FROM subpagetags WHERE subpageid=" .
        $_POST["subpageid"];
    $ResultMaxCode = mysqli_query($conn, $sqlMaxCode);

    if ($ResultMaxCode == null || mysqli_num_rows($ResultMaxCode) == 0) {
        $maxCode = 0;
    } else {
        $RowMaxCode = mysqli_fetch_assoc($ResultMaxCode);
        $maxCode = $RowMaxCode["maxCode"];
    }

    $groupCode = $maxCode + 1;

    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        echo "*error*<p>Kayıtlı dil bulunamadı!</p>";
        return;
    }

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sqlInsert =
            "INSERT INTO subpagetags (subpageid,parentid,langid,taggroupcode,type) VALUES (" .
            $_POST["subpageid"] .
            ",0," .
            $langRow["id"] .
            "," .
            $groupCode .
            ",1)";

        if (mysqli_query($conn, $sqlInsert)) {
        } else {
            echo "*error* Subpage eklenirken hata oluştu!";
            return;
        }
    }

    echo "ok";
}

function SaveSubpageTags($conn)
{
    //$subpagetagid."_name
    //$subpagetagid."_parameter
    //$subpagetagid."_typeselect
    //$subpagetagid."_value
    //_genericgroupselect
    //_listselect

    $subpagetagid = $_POST["subpagetagid"];
    $value = $_POST["value"];
    $valueField = $_POST["valueField"];
    $groupCode = $_POST["groupcode"];
    $subpageid = $_POST["subpageid"];

    if ($valueField == "genericgroupselect" || $valueField == "listselect") {
        $valueField = "value";
    }
    if ($valueField == "typeselect") {
        $valueField = "type";
    }

    //$value = str_replace("'","''" , $value );
    //$value = htmlspecialchars(urldecode($value));

    if ($valueField == "typevalueselect") {
        $sqlOrder =
            "UPDATE subpagetags SET value ='" .
            $value .
            "' WHERE subpageid=" .
            $subpageid .
            " AND taggroupcode=" .
            $groupCode;
    } else {
        if ($valueField == "value") {
            $sqlOrder =
                "UPDATE subpagetags SET " .
                $valueField .
                "='" .
                $value .
                "' WHERE id=" .
                $subpagetagid;
        } else {
            $sqlOrder =
                "UPDATE subpagetags SET " .
                $valueField .
                "='" .
                $value .
                "' WHERE subpageid=" .
                $subpageid .
                " AND taggroupcode=" .
                $groupCode;
        }
    }

    if (!mysqli_query($conn, $sqlOrder)) {
        echo "*error* Subpagetag güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function AddSubpageChild($conn)
{
    $sqlMaxCode =
        "SELECT MAX(taggroupcode) maxCode FROM subpagetags WHERE subpageid=" .
        $_POST["subpageid"];
    $ResultMaxCode = mysqli_query($conn, $sqlMaxCode);

    if ($ResultMaxCode == null || mysqli_num_rows($ResultMaxCode) == 0) {
        $maxCode = 0;
    } else {
        $RowMaxCode = mysqli_fetch_assoc($ResultMaxCode);
        $maxCode = $RowMaxCode["maxCode"];
    }

    $groupCode = $maxCode + 1;

    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        echo "*error*<p>Kayıtlı dil bulunamadı!</p>";
        return;
    }

    $parentsArr = explode("_", $_POST["parentid"]);
    $i = 0;

    while ($langRow = mysqli_fetch_assoc($langResult)) {
        $sqlInsert =
            "INSERT INTO subpagetags (subpageid,parentid,langid,taggroupcode,type) VALUES (" .
            $_POST["subpageid"] .
            "," .
            $parentsArr[$i] .
            "," .
            $langRow["id"] .
            "," .
            $groupCode .
            ",1)";

        if (mysqli_query($conn, $sqlInsert)) {
        } else {
            echo "*error* Subpage eklenirken hata oluştu!";
            return;
        }

        $i++;
    }

    echo "ok";
}

function DeleteSubpage($conn)
{
    $subpageid = $_POST["subpageid"];

    $sqlDeleteTags = "DELETE FROM subpagetags WHERE subpageid =" . $subpageid;

    if (mysqli_query($conn, $sqlDeleteTags)) {
    } else {
        echo "*error* Subpage Tags silinirken hata oluştu!";
        return;
    }

    $sqlDeleteSubpage = "DELETE FROM subpage WHERE id=" . $subpageid;

    if (mysqli_query($conn, $sqlDeleteSubpage)) {
    } else {
        echo "*error* Subpage silinirken hata oluştu!";
        return;
    }

    echo "ok";
    return;
}

function DeleteSubpageTag($conn)
{
    $idArr = [];

    $idArr = findChildren(
        $_POST["subpagetagid"],
        $_POST["subpageid"],
        $idArr,
        $conn
    );

    if (count($idArr) > 0) {
        $sqlDeleteChildren = "DELETE FROM subpagetags WHERE id IN(";

        for ($i = 0; $i < count($idArr); $i++) {
            $sqlDeleteChildren .= $idArr[$i] . ",";
        }

        $sqlDeleteChildren = rtrim($sqlDeleteChildren, ",");

        $sqlDeleteChildren .= ")";

        if (mysqli_query($conn, $sqlDeleteChildren)) {
        } else {
            echo "*error* Subpage Child Tags silinirken hata oluştu!";
            return;
        }
    }

    $sqlDeleteTags =
        "DELETE FROM subpagetags WHERE subpageid=" .
        $_POST["subpageid"] .
        " AND  taggroupcode=" .
        $_POST["taggroupcode"];

    if (mysqli_query($conn, $sqlDeleteTags)) {
    } else {
        echo "*error* Subpage Tags silinirken hata oluştu!";
        return;
    }

    echo "ok";
    return;
}

function findChildren($parentid, $subpageid, $idArr, $conn)
{
    $sql =
        "SELECT * FROM subpagetags WHERE parentid=" .
        $parentid .
        " AND subpageid=" .
        $subpageid;
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return $idArr;
    } else {
        $Row = mysqli_fetch_assoc($Result);
        $parentid = $Row["id"];
        $idArr[] = $Row["id"];

        while ($Row = mysqli_fetch_assoc($Result)) {
            $idArr[] = $Row["id"];
        }

        findChildren($parentid, $subpageid, $idArr, $conn);
    }

    return $idArr;
}

function getSubpageListSelect($tagid, $groupid, $connection)
{
    $sqlSelect = "SELECT * FROM lists";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        //return; liste yoksa yine select dönecek
    }

    $selectString = "<select id=\"" . $tagid . "_listselect\" style=\"\">";

    $selectString .= "<option value=\"0\"></option>";

    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($groupid) || $groupid != $selectRow["id"]) {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\">" .
                $selectRow["name"] .
                "</option>";
        } else {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\" selected=\"selected\">" .
                $selectRow["name"] .
                "</option>";
        }
    }

    $selectString .= "</select>";

    return $selectString;
}

function getLanguageSelectSubpage($connection)
{
    $sqlSelect = "SELECT * FROM lang";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectString = "<select id=\"subpage_langselect\" >";

    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        $selectString .=
            "<option value=\"" .
            $selectRow["id"] .
            "\">" .
            $selectRow["name"] .
            "</option>";
    }

    $selectString .= "</select>";

    return $selectString;
}

function getSubpageTagTypeList($typeid, $subpagetagid, $groupCode, $connection)
{
    $sqlSelect = "SELECT * FROM tagtype";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        //return; select her türlü dönecek
    }

    $selectString =
        "<select id=\"" .
        $subpagetagid .
        "_typeselect_" .
        $groupCode .
        "\" onchange=\"LoadTagTypeField(" .
        $subpagetagid .
        ",this);\">";

    //$selectString .="<option value=\"0\"></option>";

    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if ($typeid != $selectRow["id"]) {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\">" .
                $selectRow["name"] .
                "</option>";
        } else {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\" selected=\"selected\">" .
                $selectRow["name"] .
                "</option>";
        }
    }

    $selectString .= "</select>";

    return $selectString;
}

function getTagSubpageList($tagid, $subpageid, $connection)
{
    $sqlSelect = "SELECT * FROM subpage";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectString = "<select id=\"" . $tagid . "_subpageselect\">";

    $selectString .= "<option value=\"0\"></option>";

    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($subpageid) || $subpageid != $selectRow["id"]) {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\">" .
                $selectRow["name"] .
                "</option>";
        } else {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\" selected=\"selected\">" .
                $selectRow["name"] .
                "</option>";
        }
    }

    $selectString .= "</select>";

    return $selectString;
}

function getTypeValueSelect(
    $type,
    $tagid,
    $subpageid,
    $groupCode,
    $value,
    $conn
) {
    $includeSelect = true;

    if ($type == null) {
        $type = $_POST["type"];
        $includeSelect = false;
    }

    if ($type == null) {
        $type = $_POST["tagid"];
    }

    if ($type == null) {
        $subpageid = $_POST["subpageid"];
    }

    if ($type == null) {
        $groupCode = $_POST["groupCode"];
    }

    $selectString = "";

    if ($includeSelect == true) {
        $selectString .=
            "<select id=\"" . $tagid . "_typevalueselect_" . $groupCode . "\" ";

        if ($type == "1") {
            $selectString .= "disabled ";
        }

        $selectString .= ">";
    }

    if ($type == "2") {
        //generic

        $selectString .= getTagGenericGroupList($tagid, $value, $conn);
    }

    if ($includeSelect == true) {
        $selectString .= "</select>";
    }

    echo $selectString;
}

function getTagGenericGroupList($tagid, $value, $connection)
{
    $sqlSelect = "SELECT * FROM genericgroup";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        //return;
    }

    //$selectString = "<select id=\"".$tagid."_typeselect_".$groupCode."\">";

    $selectString = "<option value=\"0\"></option>";

    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($value) || $value != $selectRow["id"]) {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\">" .
                $selectRow["isim"] .
                "</option>";
        } else {
            $selectString .=
                "<option value=\"" .
                $selectRow["id"] .
                "\" selected=\"selected\">" .
                $selectRow["isim"] .
                "</option>";
        }
    }

    //$selectString .= "</select>";

    return $selectString;
}
