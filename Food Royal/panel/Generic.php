<?php

include "PanelGenel.php";

if (empty($_POST["call"])) {
    echo "*error* Yükleme fonksiyonu alınamadı!";
    return;
}
$callFunction = $_POST["call"];

if ($callFunction == "genericGroupSayfaYukle") {
    genericGroupSayfaYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getGroupList") {
    getGroupList($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "divTagEkleYukle") {
    divTagEkleYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericGrupEkle") {
    genericGrupEkle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericTagEkle") {
    genericTagEkle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericBaseYukle") {
    genericBaseYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "addBaseChild") {
    addBaseChild($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "removeBaseChild") {
    removeBaseChild($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagUp") {
    baseTagUp($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagDown") {
    baseTagDown($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagDelete") {
    baseTagDelete($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreYukle") {
    baseTagParametreYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreEkle") {
    baseTagParametreEkle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagParametreKaydet") {
    baseTagParametreKaydet($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseTagValueKaydet") {
    baseTagValueKaydet($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "baseGrupTumuneUygula") {
    baseGrupTumuneUygula($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getFolderImgOptions") {
    getFolderImgOptions($_POST["dir"]);
    return;
}
if ($callFunction == "checkParamHasVal") {
    checkParamHasVal($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "LoadGenericGroup") {
    LoadGenericGroup($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "genericEkle") {
    genericEkle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "ShowGenericDetail") {
    ShowGenericDetail($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "SaveGenericContent") {
    SaveGenericContent($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "GenericElementsUpdate") {
    GenericElementsUpdate($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "GenericUp") {
    GenericUp($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "GenericDown") {
    GenericDown($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "GenericDelete") {
    GenericDelete($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getSingleFolderSelect") {
    getSingleFolderSelect();
    //mysqli_close($conn);
    return;
}

function genericGroupSayfaYukle($conn)
{
    ////MÜŞTERİ TESLİMİNDE BURAYI KAPATTIM!!!
    return;

    $sql = "SELECT * FROM genericgroup";

    $Result = mysqli_query($conn, $sql);

    //    echo '<div class="divLeft">';

    echo '<div class="divHeaderAlt"><span>Gruplar</span></div>';

    echo '<div class="divGroups">';
    echo '<input type="button" value="Ekle" class="btnGrupEkle" onclick="genericGrupEklePop();" />';

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<p>Grup bulunamadı!</p>";
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo '<div id="grup_' .
            $Row["id"] .
            '" class="divGroup" onclick="genericBaseYukle(' .
            $Row["id"] .
            ');">';

        echo "<span>" . $Row["isim"] . "</span>";

        echo "</div>";
    }

    echo "</div>"; //grup div

    echo '<div class="divHeaderAlt"><span>Generic Base</span></div>';
    echo '<div id="divGenericTemplate"  class="divGenericTemplate">';

    echo "</div>"; //div genric template

    //    echo '</div>'; //div Left

    /*
    echo '<div class="divRight">';



    echo '<div class="divHeaderAlt"><span>Tag Ekle</span></div>';
    echo '<div class="divTagEkle">';

    echo '<input type="button" value="Ekle" class="btnTagEkle" onclick="genericTagEkle();" />';

    $sqlTags="SELECT * FROM generictags";
    $ResultTags = mysqli_query($conn,$sqlTags);
    if($ResultTags==NULL||mysqli_num_rows($ResultTags)==0)
    {
        echo '<p>Tag bulunamadı!</p>';

    }
    while($RowTags = mysqli_fetch_assoc($ResultTags))
    {
        echo '<div id="tag_'.$RowTags["id"].'" class="divGenericTag" onclick="tagEkleSec(this.id);">';

        echo '<span>'.$RowTags["isim"].'</span>';

        echo '</div>';

    }


    echo '</div>'; //div tag ekle



    echo '<div class="divHeaderAlt"><span>Parametreler</span></div>';
    echo '<div class="divParametreler">';


    echo '<input type="button" value="Ekle" class="btnParametreEkle" onclick="baseTagParametreEkle();" />';
    echo '<input type="button" value="Kaydet" class="btnParametreKaydet" onclick="baseTagParametreKaydet();" />';


    echo '<div id="divParametreListesi" class="divParametreListesi">';

    echo '</div>'; //div parametre listesi


    echo '</div>'; //div parametreler



    echo '<div class="divHeaderAlt"><span>Grup İşlem</span></div>';
    echo '<div class="divGrupIslem">';


    echo '<input type="button" value="Kaydet" class="btnGrupKaydet" onclick="baseGrupKaydet();" />';
    echo '<input type="button" value="Tümüne Uygula" class="btnGrupUygula" onclick="baseGrupTumuneUygulaConfirm();" />';


    echo '</div>'; //div grup işlem


    echo '</div>'; //div right*/
}

function getGroupList($conn)
{
    $sqlGroup = "SELECT * FROM genericgroup ";
    $pagesResult = mysqli_query($conn, $sqlGroup);

    ////MÜŞTERİ TESLİMİNDE BURAYI KAPATTIM!!!
    /*echo "<div id='0_page' onclick=\"LoadGenericManagement(); \" class=\"divPage\" >";

            echo "<span class='spPageName' style='color:lightgray'>Base Yönetim</span>";

    echo "</div>";*/

    while ($group = mysqli_fetch_assoc($pagesResult)) {
        echo "<div id=\"" .
            $group["id"] .
            "_page\" onclick=\"LoadGenericGroup(" .
            $group["id"] .
            "); \" class=\"divPage\" >";

        echo "<span class='spPageName'>" . $group["isim"] . "</span>";

        echo "</div>";
    }
}

function divTagEkleYukle($conn)
{
    echo '<div class="divHeaderAlt"><span>Tag Ekle</span></div>';
    echo '<div class="divTagEkleContent">';

    echo '<input type="button" value="Ekle" class="btnTagEkle" onclick="genericTagEkle();" />';

    $sqlTags = "SELECT * FROM generictags";
    $ResultTags = mysqli_query($conn, $sqlTags);
    if ($ResultTags == null || mysqli_num_rows($ResultTags) == 0) {
        echo "<p>Tag bulunamadı!</p>";
    }
    while ($RowTags = mysqli_fetch_assoc($ResultTags)) {
        echo '<div id="tag_' .
            $RowTags["id"] .
            '" class="divGenericTag" onclick="tagEkleSec(this.id);">';

        echo "<span>" . $RowTags["isim"] . "</span>";

        echo "</div>";
    }

    echo "</div>"; //div tag ekle
}

function genericGrupEkle($conn)
{
    $sqlInsert =
        "INSERT INTO genericgroup (isim) VALUES ('" . $_POST["isim"] . "')";

    if (mysqli_query($conn, $sqlInsert)) {
        echo "ok";
    } else {
        echo "*error* Generic group eklenirken hata oluştu!";
    }
}

function genericTagEkle($conn)
{
    $sqlOrder =
        "SELECT MAX(sira) maxOrder FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"];
    $ResultOrder = mysqli_query($conn, $sqlOrder);

    if ($ResultOrder == null || mysqli_num_rows($ResultOrder) == 0) {
        $maxOrder = 0;
    } else {
        $Row = mysqli_fetch_assoc($ResultOrder);
        $maxOrder = $Row["maxOrder"];
    }

    $order = $maxOrder + 1;

    if ($_POST["tag"] == "div") {
        echo divEkle($order, $conn);
    }

    if ($_POST["tag"] == "span") {
        echo spanEkle($order, $conn);
    }

    if ($_POST["tag"] == "textbox") {
        echo textboxEkle($order, $conn);
    }

    if ($_POST["tag"] == "textarea") {
        echo textareaEkle($order, $conn);
    }

    if ($_POST["tag"] == "img") {
        echo imgEkle($order, $conn);
    }

    if ($_POST["tag"] == "h1") {
        echo h1Ekle($order, $conn);
    }

    if ($_POST["tag"] == "p") {
        echo pEkle($order, $conn);
    }

    if ($_POST["tag"] == "module") {
        echo moduleEkle($order, $conn);
    }

    if ($_POST["tag"] == "list") {
        echo listEkle($order, $conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function divEkle($order, $conn)
{
    $sqlMaxCode =
        "SELECT MAX(taggroupcode) maxCode FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"];
    $ResultMaxCode = mysqli_query($conn, $sqlMaxCode);

    if ($ResultMaxCode == null || mysqli_num_rows($ResultMaxCode) == 0) {
        $maxCode = 0;
    } else {
        $RowMaxCode = mysqli_fetch_assoc($ResultMaxCode);
        $maxCode = $RowMaxCode["maxCode"];
    }

    $groupCode = $maxCode + 1;

    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, taggroupcode,sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','div'," .
        $groupCode .
        "," .
        $order .
        "),
                           ('" .
        $_POST["grupid"] .
        "','/div'," .
        $groupCode .
        "," .
        ++$order .
        " )";
    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function spanEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','span',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function textboxEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','textbox',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function textareaEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','textarea',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function imgEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','img',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function h1Ekle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','h1',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function pEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','p',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function moduleEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','module',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function listEkle($order, $conn)
{
    $sqlInsert =
        "INSERT INTO genericbase (genericgroupid, tag, sira)
                    VALUES ('" .
        $_POST["grupid"] .
        "','list',$order )";

    if (mysqli_query($conn, $sqlInsert)) {
        return "ok";
    } else {
        return "*error* Generic tag eklenirken hata oluştu!";
    }
}

function genericBaseYukle($conn)
{
    $sqlTags =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        "  ORDER BY sira";
    $ResultTags = mysqli_query($conn, $sqlTags);
    if ($ResultTags == null || mysqli_num_rows($ResultTags) == 0) {
        echo "<p>Tag bulunamadı!</p>";
        return;
    }
    while ($RowTags = mysqli_fetch_assoc($ResultTags)) {
        if ($RowTags["tag"] == "/div") {
            echo "</div>";
            continue;
        }

        echo '<div id="headerTag_' .
            $RowTags["id"] .
            '" class="baseHeader" onclick="baseTagSec(' .
            $RowTags["id"] .
            ');">
                <span>' .
            $RowTags["tag"] .
            '</span>
              </div>';

        if ($RowTags["tag"] == "div") {
            divYukle($RowTags);
        }

        if ($RowTags["tag"] == "span") {
            spanYukle($RowTags);
        }

        if ($RowTags["tag"] == "textbox") {
            textboxYukle($RowTags);
        }

        if ($RowTags["tag"] == "textarea") {
            textareaYukle($RowTags);
        }

        if ($RowTags["tag"] == "img") {
            imgYukle($RowTags);
        }

        if ($RowTags["tag"] == "h1") {
            h1Yukle($RowTags);
        }

        if ($RowTags["tag"] == "p") {
            pYukle($RowTags);
        }

        if ($RowTags["tag"] == "module") {
            moduleYukle($RowTags, $conn);
        }

        if ($RowTags["tag"] == "list") {
            listYukle($RowTags, $conn);
        }
    }
}

function divYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagBig" >';

    echo '<div class="tagControls">
		<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2" onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> ';
}

function spanYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> ';

    echo '<input id="' .
        $RowTags["id"] .
        '_value" type="text" value="' .
        $RowTags["value"] .
        '" />';

    echo "</div>";
}

function textboxYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> ';

    echo '<input id="' .
        $RowTags["id"] .
        '_value" type="text" value="' .
        $RowTags["value"] .
        '" />';

    echo "</div>";
}

function textareaYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> '; //tag controls

    echo '<textarea id="' .
        $RowTags["id"] .
        '_value">' .
        $RowTags["value"] .
        "</textarea>";

    echo "</div>"; //base tag
}

function imgYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>';

    echo "</div> "; //tag controls

    $files = scandir("../img");

    echo "<img id=\"" . $RowTags["id"] . "_img\" />";
    echo "<input id=\"" .
        $RowTags["id"] .
        "_value\" type=\"hidden\" value=\"" .
        $RowTags["value"] .
        "\" />";
    echo "<label>img/</label>";

    echo "<div id=\"divSelects_" . $RowTags["id"] . "\">";

    $pathArr = explode("/", $RowTags["value"]);

    echo "<select onchange='baseImgOnchange(this);'>";
    echo "<option></option>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        if (count($pathArr) > 0 && $pathArr[0] == $folder) {
            echo "<option selected='selected'>" . $folder . "</option>";
        } else {
            echo "<option>" . $folder . "</option>";
        }
    }

    echo "</select>";

    if (count($pathArr) > 1) {
        for ($i = 1; $i < count($pathArr); $i++) {
            $pathString = "../img";
            for ($j = 0; $j < $i; $j++) {
                $pathString .= "/" . $pathArr[$j];
            }

            $files = scandir($pathString);

            echo "<select onchange='baseImgOnchange(this);'>";
            echo "<option></option>";

            foreach ($files as $folder) {
                if ($folder == "Thumbs.db") {
                    continue;
                }

                if ($folder == "." || $folder == "..") {
                    continue;
                }

                if (count($pathArr) > 0 && $pathArr[$i] == $folder) {
                    echo "<option selected='selected'>" . $folder . "</option>";
                } else {
                    echo "<option>" . $folder . "</option>";
                }
            }

            echo "</select>";
        }
    }

    echo "</div>"; //divselects

    echo "</div>"; //base tag
}

function h1Yukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> '; //tag controls

    echo '<input id="' .
        $RowTags["id"] .
        '_value" type="text" value="' .
        $RowTags["value"] .
        '" />';

    echo "</div>"; //base tag
}

function pYukle($RowTags)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> '; //tag controls

    echo '<textarea id="' .
        $RowTags["id"] .
        '_value">' .
        $RowTags["value"] .
        "</textarea>";

    echo "</div>"; //base tag
}

function moduleYukle($RowTags, $conn)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> ';

    echo "<label>Modül:</label> &nbsp;" .
        getModuleSelectGeneric($RowTags["id"], $RowTags["value"], $conn);

    echo "</div>";
}

function listYukle($RowTags, $conn)
{
    echo '<div id="baseTag_' . $RowTags["id"] . '" class="baseTagSmall" >';
    echo '<div class="tagControls">
			<span class="arrow_carrot-up_alt2" onclick="baseTagUp(' .
        $RowTags["id"] .
        ');"></span><span class="arrow_carrot-down_alt2" onclick="baseTagDown(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="arrow_carrot-left_alt2" onclick="baseTagSec(' .
        $RowTags["id"] .
        '); showBaseTargets();"></span>';
    echo '<span class="arrow_carrot-right_alt2" onclick="removeBaseChild(' .
        $RowTags["id"] .
        ');"></span>';

    echo '<span class="icon_close_alt2"  onclick="baseTagDeleteConfirm(' .
        $RowTags["id"] .
        ');"></span>
			</div> ';

    echo "<label>Liste:</label> &nbsp;" .
        getListSelect($RowTags["value"], $conn);

    echo "</div>";
}

function getFolderImgOptions($dir, $selectedFile)
{
    if ($dir == "root") {
        $dir = "";
    }

    $files = scandir("../img/" . $dir);

    echo "<option></option>";

    foreach ($files as $file) {
        if ($file == "Thumbs.db") {
            continue;
        }

        if ($file == "." || $file == "..") {
            continue;
        }

        if (!is_dir("../img/" . $file)) {
            if ($selectedFile == $file) {
                echo "<option selected=\"selected\">" . $file . "</option>";
            } else {
                echo "<option>" . $file . "</option>";
            }
        }
    }
}

function getModuleSelectGeneric($elementid, $moduleType, $connection)
{
    $sqlSelect = "SELECT * FROM modules";
    $selectResult = mysqli_query($connection, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectString = "<select id=\"" . $elementid . "_value\" >";
    $selectString .= "<option></option>";
    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($moduleType) || $moduleType != $selectRow["type"]) {
            $selectString .= "<option >" . $selectRow["type"] . "</option>";
        } else {
            $selectString .=
                "<option selected=\"selected\">" .
                $selectRow["type"] .
                "</option>";
        }
    }

    $selectString .= "</select>";

    return $selectString;
}

function getListSelect($id, $conn)
{
    $sqlSelect = "SELECT * FROM lists";
    $selectResult = mysqli_query($conn, $sqlSelect);

    if ($selectResult == null || mysqli_num_rows($selectResult) == 0) {
        return;
    }

    $selectString = "<select id=\"" . $id . "_value\" >";
    $selectString .= "<option></option>";
    while ($selectRow = mysqli_fetch_assoc($selectResult)) {
        if (empty($moduleType) || $id != $selectRow["id"]) {
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

function addBaseChild($conn)
{
    //****child tag bilgileri alnıyor. tek tag ise veya blok ise ona göre fonksiyonlar çağırılack

    $sqlChild = "SELECT * FROM genericbase WHERE id=" . $_POST["childid"];
    $ResultChild = mysqli_query($conn, $sqlChild);
    if ($ResultChild == null || mysqli_num_rows($ResultChild) == 0) {
        echo "<p>Çocuk tag bulunamadı!</p>";
        return;
    }
    $RowChild = mysqli_fetch_assoc($ResultChild);

    $childTag = $RowChild["tag"];

    if ($childTag == "div") {
        addBaseChildBlock($RowChild, $conn);
    } else {
        addBaseChildTag($conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function addBaseChildTag($conn)
{
    //****kapanış tagi bulunup sıra numarası alınıyor****//

    $sqlCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND taggroupcode=(SELECT taggroupcode FROM genericbase WHERE id=" .
        $_POST["parentid"] .
        ")";
    $ResultCloseTag = mysqli_query($conn, $sqlCloseTag);
    if ($ResultCloseTag == null || mysqli_num_rows($ResultCloseTag) == 0) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }
    $RowCloseTag = mysqli_fetch_assoc($ResultCloseTag);

    $kapanisTagSira = $RowCloseTag["sira"];

    //****kapanış tagi ve sonraki tüm sıralar 1 artıyor****//

    $sqlUpdateOrder1 =
        "UPDATE genericbase SET sira = sira+1
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $kapanisTagSira;

    if (!mysqli_query($conn, $sqlUpdateOrder1)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    //****child tag sıra numarası alınıyor
    $sqlChildOrder = "SELECT * FROM genericbase WHERE id=" . $_POST["childid"];
    $ResultChildOrder = mysqli_query($conn, $sqlChildOrder);
    if ($ResultChildOrder == null || mysqli_num_rows($ResultChildOrder) == 0) {
        echo "<p>Çocuk tag bulunamadı!</p>";
        return;
    }
    $RowChildOrder = mysqli_fetch_assoc($ResultChildOrder);

    $childTagSira = $RowChildOrder["sira"];

    //****chid tag'in sıra numarası parentin en alt sırasına eşitleniyor****//
    $sqlUpdateOrder2 =
        "UPDATE genericbase SET sira = " .
        $kapanisTagSira .
        "
                         WHERE  id=" .
        $_POST["childid"];

    if (!mysqli_query($conn, $sqlUpdateOrder2)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    //****child tag sırası taşındığı için ondan sonraki tüm sıralar 1 azaltılacak****//
    $sqlUpdateOrder3 =
        "UPDATE genericbase SET sira = sira-1
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $childTagSira;

    if (!mysqli_query($conn, $sqlUpdateOrder3)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    echo "ok";
}

function addBaseChildBlock($RowChild, $conn)
{
    //child block count bulunuyor

    $sqlChildCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND taggroupcode=" .
        $RowChild["tagGroupCode"] .
        "  LIMIT 1";
    $ResultChildCloseTag = mysqli_query($conn, $sqlChildCloseTag);
    if (
        $ResultChildCloseTag == null &&
        mysqli_num_rows($ResultChildCloseTag) == 0
    ) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }

    $RowChildCloseTag = mysqli_fetch_assoc($ResultChildCloseTag);

    $childBlockCount =
        intval($RowChildCloseTag["sira"]) - intval($RowChild["sira"]) + 1;

    //****parent kapanış tagi bulunup sıra numarası alınıyor****//

    $sqlCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND taggroupcode=(SELECT taggroupcode FROM genericbase WHERE id=" .
        $_POST["parentid"] .
        ")";
    $ResultCloseTag = mysqli_query($conn, $sqlCloseTag);
    if ($ResultCloseTag == null || mysqli_num_rows($ResultCloseTag) == 0) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }
    $RowCloseTag = mysqli_fetch_assoc($ResultCloseTag);

    $kapanisTagSira = $RowCloseTag["sira"];

    $yeniChildBaslangic = $kapanisTagSira;

    //****kapanış tagi ve sonraki tüm sıralar child block count kadar artıyor****//

    $sqlUpdateOrder1 =
        "UPDATE genericbase SET sira = sira+" .
        $childBlockCount .
        "
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $kapanisTagSira;

    if (!mysqli_query($conn, $sqlUpdateOrder1)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    /* child bloğunun yazılacağı başlangıç sırası child bloğunun orjinal başlangıç numarasından büyükse
       child blok yukarı kaydırılacak demektir. child başlangıç sırası bir önceki sıra güncellemesinden etkilendiyse
       parent div'den daha büyük sıraya sahip demektir. eğer etkilenmediyse child blok aşağı kaydırılacak
    */

    $sqlChild = "SELECT * FROM genericbase WHERE id=" . $_POST["childid"];
    $ResultChild = mysqli_query($conn, $sqlChild);
    if ($ResultChild == null || mysqli_num_rows($ResultChild) == 0) {
        echo "<p>Çocuk tag bulunamadı!</p>";
        return;
    }
    $RowChild = mysqli_fetch_assoc($ResultChild);

    if (intval($yeniChildBaslangic) > intval($RowChild["sira"])) {
        $startOffset = intval($yeniChildBaslangic) - intval($RowChild["sira"]);

        $sqlUpdateOrder2 =
            "UPDATE genericbase SET sira = sira +" .
            $startOffset .
            "
                         	WHERE  sira >=" .
            $RowChild["sira"] .
            " AND sira <" .
            $RowChild["sira"] .
            "+" .
            $childBlockCount;

        if (!mysqli_query($conn, $sqlUpdateOrder2)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }
    } else {
        $startOffset = intval($RowChild["sira"]) - intval($yeniChildBaslangic);

        $sqlUpdateOrder2 =
            "UPDATE genericbase SET sira = sira -" .
            $startOffset .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND  sira >=" .
            $RowChild["sira"] .
            " AND sira <" .
            $RowChild["sira"] .
            "+" .
            $childBlockCount;

        if (!mysqli_query($conn, $sqlUpdateOrder2)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }
    }

    //****child tag bloğu taşındığı için ondan sonraki tüm sıralar block count kadar azaltılacak****//
    $sqlUpdateOrder3 =
        "UPDATE genericbase SET sira = sira-" .
        $childBlockCount .
        "
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $RowChild["sira"];

    if (!mysqli_query($conn, $sqlUpdateOrder3)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    echo "ok";
}

function removeBaseChild($conn)
{
    //****child tag bilgileri alnıyor. tek tag ise veya blok ise ona göre fonksiyonlar çağırılack

    $sqlChild = "SELECT * FROM genericbase WHERE id=" . $_POST["childid"];
    $ResultChild = mysqli_query($conn, $sqlChild);
    if ($ResultChild == null || mysqli_num_rows($ResultChild) == 0) {
        echo "<p>Çocuk tag bulunamadı!</p>";
        return;
    }
    $RowChild = mysqli_fetch_assoc($ResultChild);

    $childTag = $RowChild["tag"];

    if ($childTag == "div") {
        removeBaseChildBlock($RowChild, $conn);
    } else {
        removeBaseChildTag($conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function removeBaseChildTag($conn)
{
    /*child tagin sıra numarası alınıyor*/
    $sqlTag = "SELECT * FROM genericbase WHERE id=" . $_POST["childid"];
    $ResultTag = mysqli_query($conn, $sqlTag);
    if ($ResultTag == null || mysqli_num_rows($ResultTag) == 0) {
        echo "<p>Tag bulunamadı!</p>";
        return;
    }
    $RowTag = mysqli_fetch_assoc($ResultTag);

    $childOrder = $RowTag["sira"];

    /*kapanış tagi bulunuyor ve sıra numarası alınıyor*/

    $sqlCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND sira>" .
        $childOrder .
        "
					AND taggroupcode=
					(SELECT taggroupcode FROM genericbase WHERE sira<" .
        $childOrder .
        " AND genericgroupid=" .
        $_POST["grupid"] .
        "  ORDER BY sira DESC LIMIT 1)
					 ORDER BY sira ASC LIMIT 1";
    $ResultCloseTag = mysqli_query($conn, $sqlCloseTag);
    if ($ResultCloseTag == null || mysqli_num_rows($ResultCloseTag) == 0) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }
    $RowCloseTag = mysqli_fetch_assoc($ResultCloseTag);

    $closeTagOrder = $RowCloseTag["sira"];

    /*child tag sıra nosundan kapanış sırasına kadar sıralar 1er azaltılıyor	*/

    $sqlUpdateOrder1 =
        "UPDATE genericbase SET sira = sira-1
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $childOrder .
        " AND sira <=" .
        $closeTagOrder;

    if (!mysqli_query($conn, $sqlUpdateOrder1)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    /*tagin sıra nosu child tagin sıra nosuna eşitleniyor*/
    $sqlUpdateOrder2 =
        "UPDATE genericbase SET sira = " .
        $closeTagOrder .
        "
                         WHERE  id=" .
        $_POST["childid"];

    if (!mysqli_query($conn, $sqlUpdateOrder2)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    echo "ok";
}

function removeBaseChildBlock($RowChild, $conn)
{
    //child block count bulunuyor

    $sqlChildCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND taggroupcode=" .
        $RowChild["tagGroupCode"] .
        "  LIMIT 1";
    $ResultChildCloseTag = mysqli_query($conn, $sqlChildCloseTag);
    if (
        $ResultChildCloseTag == null &&
        mysqli_num_rows($ResultChildCloseTag) == 0
    ) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }

    $RowChildCloseTag = mysqli_fetch_assoc($ResultChildCloseTag);

    $childBlockCount =
        intval($RowChildCloseTag["sira"]) - intval($RowChild["sira"]) + 1;

    //****parent kapanış tagi bulunup sıra numarası alınıyor****//

    $sqlCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div'
					AND sira>" .
        $RowChildCloseTag["sira"] .
        "
					AND taggroupcode=
					(SELECT taggroupcode FROM genericbase WHERE sira<" .
        $RowChild["sira"] .
        " AND genericgroupid=" .
        $_POST["grupid"] .
        "  ORDER BY sira DESC LIMIT 1)
					ORDER BY sira ASC LIMIT 1";
    $ResultCloseTag = mysqli_query($conn, $sqlCloseTag);
    if ($ResultCloseTag == null || mysqli_num_rows($ResultCloseTag) == 0) {
        echo "<p>Kapanış Tagi bulunamadı!</p>";
        return;
    }
    $RowCloseTag = mysqli_fetch_assoc($ResultCloseTag);

    $kapanisTagSira = $RowCloseTag["sira"];

    //****kapanış taginden sonraki tüm sıralar child block count kadar artıyor****//

    $sqlUpdateOrder1 =
        "UPDATE genericbase SET sira = sira+" .
        $childBlockCount .
        "
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >" .
        $kapanisTagSira;

    if (!mysqli_query($conn, $sqlUpdateOrder1)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    /* child block parent kapanış taginden itibaren yazılıyor */
    $endOffset = intval($kapanisTagSira) - intval($RowChild["sira"]) + 1;

    $sqlUpdateOrder2 =
        "UPDATE genericbase SET sira = sira +" .
        $endOffset .
        "
                         	WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND  sira >=" .
        $RowChild["sira"] .
        " AND sira <" .
        $RowChild["sira"] .
        "+" .
        $childBlockCount;

    if (!mysqli_query($conn, $sqlUpdateOrder2)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    //****child tag bloğu taşındığı için ondan sonraki tüm sıralar block count kadar azaltılacak****//
    $sqlUpdateOrder3 =
        "UPDATE genericbase SET sira = sira-" .
        $childBlockCount .
        "
                         WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $RowChild["sira"];

    if (!mysqli_query($conn, $sqlUpdateOrder3)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    echo "ok";
}

function baseTagUp($conn)
{
    // tag bilgileri alnıyor. tek tag ise veya blok ise ona göre fonksiyonlar çağırılack

    $sqlTag = "SELECT * FROM genericbase WHERE id=" . $_POST["tagid"];
    $ResultTag = mysqli_query($conn, $sqlTag);
    if ($ResultTag == null || mysqli_num_rows($ResultTag) == 0) {
        echo "<p>Tag bulunamadı!</p>";
        return;
    }
    $RowTag = mysqli_fetch_assoc($ResultTag);

    $Tag = $RowTag["tag"];

    if ($Tag == "div") {
        baseTagUpBlock($RowTag, $conn);
    } else {
        baseTagUpSingle($RowTag, $conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function baseTagUpSingle($RowTag, $conn)
{
    /*kaynak tagin sıra numarasından bir önceki tag'e bakılıyor*/

    $sqlTargetTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira=" .
        $RowTag["sira"] .
        "-1";
    $ResultTargetTag = mysqli_query($conn, $sqlTargetTag);
    if ($ResultTargetTag == null || mysqli_num_rows($ResultTargetTag) == 0) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowTargetTag = mysqli_fetch_assoc($ResultTargetTag);

    $TargetTag = $RowTargetTag["tag"];

    /*eğer bir önceki tag blok başlangıcı ise return ediyoruz, yukarı taşımak için önce removeChild işlemi yapılacak*/
    if ($TargetTag == "div") {
        echo "ok";
        return;
    }

    /*önceki tag blok ise açılış tagi bulunuyor ve tüm hedef divin sıraları 1 artıyor tagin sıra nosu hedefin başlangıç
    numarasına eşitlenir
      blok değilse kaynak tagin sıra numarası 1 azalır ve hedefinki 1 artar*/

    if ($TargetTag == "/div") {
        $sqlTargetOpenTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='div' AND taggroupcode=" .
            $RowTargetTag["tagGroupCode"];
        $ResultTargetOpenTag = mysqli_query($conn, $sqlTargetOpenTag);
        if (
            $ResultTargetOpenTag == null ||
            mysqli_num_rows($ResultTargetOpenTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetOpenTag = mysqli_fetch_assoc($ResultTargetOpenTag);

        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = sira +1
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTargetOpenTag["sira"] .
            " AND sira <=" .
            $RowTargetTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = " .
            $RowTargetOpenTag["sira"] .
            "
                         	WHERE id=" .
            $RowTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    } else {
        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = sira+1
                         	WHERE id=" . $RowTargetTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }

        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = sira-1
                         	WHERE id=" . $RowTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    }

    echo "ok";
}

function baseTagUpBlock($RowTag, $conn)
{
    /*kaynak tagin sıra numarasından bir önceki tag'e bakılıyor*/

    $sqlTargetTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira=" .
        $RowTag["sira"] .
        "-1";
    $ResultTargetTag = mysqli_query($conn, $sqlTargetTag);
    if ($ResultTargetTag == null || mysqli_num_rows($ResultTargetTag) == 0) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowTargetTag = mysqli_fetch_assoc($ResultTargetTag);

    $TargetTag = $RowTargetTag["tag"];

    /*eğer bir önceki tag blok başlangıcı ise return ediyoruz, yukarı taşımak için önce removeChild işlemi yapılacak*/
    if ($TargetTag == "div") {
        echo "ok";
        return;
    }

    if ($TargetTag == "/div") {
        /*kaynak blok count bulunuyor*/

        $sqlSourceTagClose =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div'
					AND taggroupcode=" .
            $RowTag["tagGroupCode"] .
            "  LIMIT 1";
        $ResultSourceTagClose = mysqli_query($conn, $sqlSourceTagClose);
        if (
            $ResultSourceTagClose == null &&
            mysqli_num_rows($ResultSourceTagClose) == 0
        ) {
            echo "<p>Kapanış Tagi bulunamadı!</p>";
            return;
        }

        $RowSourceTagClose = mysqli_fetch_assoc($ResultSourceTagClose);

        $sourceBlockCount =
            intval($RowSourceTagClose["sira"]) - intval($RowTag["sira"]) + 1;

        /*hedef blok başlangıcı ve hedef blok count bulunuyor*/

        $sqlTargetOpenTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='div' AND taggroupcode=" .
            $RowTargetTag["tagGroupCode"];
        $ResultTargetOpenTag = mysqli_query($conn, $sqlTargetOpenTag);
        if (
            $ResultTargetOpenTag == null ||
            mysqli_num_rows($ResultTargetOpenTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetOpenTag = mysqli_fetch_assoc($ResultTargetOpenTag);

        $targetBlockCount =
            intval($RowTargetTag["sira"]) -
            intval($RowTargetOpenTag["sira"]) +
            1;

        /*hedef blok başlangıcından büyük tüm sıralar kaynak sırası kadar artırılıyor*/

        $sqlUpdateOrder1 =
            "UPDATE genericbase SET sira = sira + " .
            $sourceBlockCount .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTargetOpenTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder1)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*kaynak blok ve hedef blok sayıları toplanıyor, offset sayısı bulunuyor*/
        $offset = $targetBlockCount + $sourceBlockCount;

        /*kaynak blok açılış ve kapanış tagi bulunuyor*/

        $sqlSourceOpenTag =
            "SELECT * FROM genericbase WHERE id=" . $RowTag["id"];
        $ResultSourceOpenTag = mysqli_query($conn, $sqlSourceOpenTag);
        if (
            $ResultSourceOpenTag == null ||
            mysqli_num_rows($ResultSourceOpenTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowSourceOpenTag = mysqli_fetch_assoc($ResultSourceOpenTag);

        $sqlSourceCloseTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div' AND taggroupcode=" .
            $RowTag["tagGroupCode"];
        $ResultSourceCloseTag = mysqli_query($conn, $sqlSourceCloseTag);
        if (
            $ResultSourceCloseTag == null ||
            mysqli_num_rows($ResultSourceCloseTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowSourceCloseTag = mysqli_fetch_assoc($ResultSourceCloseTag);

        /*kaynak blok sıraları offset kadar azaltılıyor*/

        $sqlUpdateOrder2 =
            "UPDATE genericbase SET sira = sira - " .
            $offset .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowSourceOpenTag["sira"] .
            " AND sira <=" .
            $RowSourceCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder2)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*kaynak blok bitişinden büyük tüm sıralar kaynak blok count kadar azaltılıyor*/

        $sqlUpdateOrder3 =
            "UPDATE genericbase SET sira = sira - " .
            $sourceBlockCount .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >" .
            $RowSourceCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder3)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }
    } else {
        /*kaynak blok kapanış tagi bulunuyor*/
        $sqlSourceCloseTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div' AND taggroupcode=" .
            $RowTag["tagGroupCode"];
        $ResultSourceCloseTag = mysqli_query($conn, $sqlSourceCloseTag);
        if (
            $ResultSourceCloseTag == null ||
            mysqli_num_rows($ResultSourceCloseTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowSourceCloseTag = mysqli_fetch_assoc($ResultSourceCloseTag);

        /*kaynak blok sıra numaraları 1 azaltılıyor*/
        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = sira -1
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTag["sira"] .
            " AND sira <=" .
            $RowSourceCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*hedef tag sıra numarası kaynağın önceki bitişine eşitleniyor*/
        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = " .
            $RowSourceCloseTag["sira"] .
            "
                         	    WHERE id=" .
            $RowTargetTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    }

    echo "ok";
}

function baseTagDown($conn)
{
    // tag bilgileri alnıyor. tek tag ise veya blok ise ona göre fonksiyonlar çağırılack

    $sqlTag = "SELECT * FROM genericbase WHERE id=" . $_POST["tagid"];
    $ResultTag = mysqli_query($conn, $sqlTag);
    if ($ResultTag == null || mysqli_num_rows($ResultTag) == 0) {
        echo "<p>Tag bulunamadı!</p>";
        return;
    }
    $RowTag = mysqli_fetch_assoc($ResultTag);

    $Tag = $RowTag["tag"];

    if ($Tag == "div") {
        baseTagDownBlock($RowTag, $conn);
    } else {
        baseTagDownSingle($RowTag, $conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function baseTagDownSingle($RowTag, $conn)
{
    /*kaynak tagin sıra numarasından bir sonraki tag'e bakılıyor*/

    $sqlTargetTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira=" .
        $RowTag["sira"] .
        "+1";
    $ResultTargetTag = mysqli_query($conn, $sqlTargetTag);
    if ($ResultTargetTag == null || mysqli_num_rows($ResultTargetTag) == 0) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowTargetTag = mysqli_fetch_assoc($ResultTargetTag);

    $TargetTag = $RowTargetTag["tag"];

    /*eğer bir önceki tag blok bitişi ise return ediyoruz, aşağı taşımak için önce removeChild işlemi yapılacak*/
    if ($TargetTag == "/div") {
        echo "ok";
        return;
    }

    /*önceki tag blok ise kapanış tagi bulunuyor ve tüm hedef divin sıraları 1 azalıyor. kaynak tagin sıra nosu hedefin bitiş
      numarasına eşitlenir
      blok değilse kaynak tagin sıra numarası 1 artar ve hedefinki 1 azalır*/

    if ($TargetTag == "div") {
        $sqlTargetCloseTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div' AND taggroupcode=" .
            $RowTargetTag["tagGroupCode"];
        $ResultTargetCloseTag = mysqli_query($conn, $sqlTargetCloseTag);
        if (
            $ResultTargetCloseTag == null ||
            mysqli_num_rows($ResultTargetCloseTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetCloseTag = mysqli_fetch_assoc($ResultTargetCloseTag);

        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = sira - 1
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTargetTag["sira"] .
            " AND sira <=" .
            $RowTargetCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = " .
            $RowTargetCloseTag["sira"] .
            "
                         	WHERE id=" .
            $RowTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    } else {
        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = sira-1
                         	WHERE id=" . $RowTargetTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }

        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = sira+1
                         	WHERE id=" . $RowTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    }

    echo "ok";
}

function baseTagDownBlock($RowTag, $conn)
{
    /*kaynak blok kapanış tagi bulunuyor*/

    $sqlSourceCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div' AND taggroupcode=" .
        $RowTag["tagGroupCode"];
    $ResultSourceCloseTag = mysqli_query($conn, $sqlSourceCloseTag);
    if (
        $ResultSourceCloseTag == null ||
        mysqli_num_rows($ResultSourceCloseTag) == 0
    ) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowSourceCloseTag = mysqli_fetch_assoc($ResultSourceCloseTag);

    /*kaynak tagin kapanış sıra numarasından bir sonraki tag'e bakılıyor*/

    $sqlTargetTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira=" .
        $RowSourceCloseTag["sira"] .
        "+1";
    $ResultTargetTag = mysqli_query($conn, $sqlTargetTag);
    if ($ResultTargetTag == null || mysqli_num_rows($ResultTargetTag) == 0) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowTargetTag = mysqli_fetch_assoc($ResultTargetTag);

    $TargetTag = $RowTargetTag["tag"];

    /*eğer bir sonraki tag blok bitişi ise return ediyoruz, yukarı taşımak için önce removeChild işlemi yapılacak*/
    if ($TargetTag == "/div") {
        echo "ok";
        return;
    }

    if ($TargetTag == "div") {
        /*kaynak blok count bulunuyor*/

        $sourceBlockCount =
            intval($RowSourceCloseTag["sira"]) - intval($RowTag["sira"]) + 1;

        /*hedef blok bitişi ve hedef blok count bulunuyor*/

        $sqlTargetCloseTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div' AND taggroupcode=" .
            $RowTargetTag["tagGroupCode"];
        $ResultTargetCloseTag = mysqli_query($conn, $sqlTargetCloseTag);
        if (
            $ResultTargetCloseTag == null ||
            mysqli_num_rows($ResultTargetCloseTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetCloseTag = mysqli_fetch_assoc($ResultTargetCloseTag);

        $targetBlockCount =
            intval($RowTargetCloseTag["sira"]) -
            intval($RowTargetTag["sira"]) +
            1;

        /*kaynak blok başlangıcından büyük tüm sıralar hedef count sırası kadar artırılıyor*/

        $sqlUpdateOrder1 =
            "UPDATE genericbase SET sira = sira + " .
            $targetBlockCount .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder1)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*kaynak blok ve hedef blok sayıları toplanıyor, offset sayısı bulunuyor*/
        $offset = $targetBlockCount + $sourceBlockCount;

        /*hedef blok açılış ve kapanış tagi tekrar bulunuyor*/

        $sqlTargetOpenTag =
            "SELECT * FROM genericbase WHERE id=" . $RowTargetTag["id"];
        $ResultTargetOpenTag = mysqli_query($conn, $sqlTargetOpenTag);
        if (
            $ResultTargetOpenTag == null ||
            mysqli_num_rows($ResultTargetOpenTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetOpenTag = mysqli_fetch_assoc($ResultTargetOpenTag);

        $sqlTargetCloseTag =
            "SELECT * FROM genericbase WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND tag='/div' AND taggroupcode=" .
            $RowTargetTag["tagGroupCode"];
        $ResultTargetCloseTag = mysqli_query($conn, $sqlTargetCloseTag);
        if (
            $ResultTargetCloseTag == null ||
            mysqli_num_rows($ResultTargetCloseTag) == 0
        ) {
            echo "<p>Target Tag bulunamadı!</p>";
            return;
        }
        $RowTargetCloseTag = mysqli_fetch_assoc($ResultTargetCloseTag);

        /*hedef blok sıraları offset kadar azaltılıyor*/

        $sqlUpdateOrder2 =
            "UPDATE genericbase SET sira = sira - " .
            $offset .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTargetOpenTag["sira"] .
            " AND sira <=" .
            $RowTargetCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder2)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*hedef blok bitişinden büyük tüm sıralar hedef blok count kadar azaltılıyor*/

        $sqlUpdateOrder3 =
            "UPDATE genericbase SET sira = sira - " .
            $targetBlockCount .
            "
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >" .
            $RowTargetCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrder3)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }
    } else {
        /*kaynak blok sıra numaraları 1 artırılıyor*/
        $sqlUpdateOrderSource =
            "UPDATE genericbase SET sira = sira +1
                         	WHERE genericgroupid=" .
            $_POST["grupid"] .
            " AND sira >=" .
            $RowTag["sira"] .
            " AND sira <=" .
            $RowSourceCloseTag["sira"];

        if (!mysqli_query($conn, $sqlUpdateOrderSource)) {
            echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
            return;
        }

        /*hedef tag sıra numarası kaynağın önceki bitişine eşitleniyor*/
        $sqlUpdateOrderTarget =
            "UPDATE genericbase SET sira = " .
            $RowTag["sira"] .
            "
                         	    WHERE id=" .
            $RowTargetTag["id"];

        if (!mysqli_query($conn, $sqlUpdateOrderTarget)) {
            echo "<p>Sıra numarası güncellenirken hata oluştu!</p>";
            return;
        }
    }

    echo "ok";
}

function baseTagDelete($conn)
{
    // tag bilgileri alnıyor. tek tag ise veya blok ise ona göre fonksiyonlar çağırılack

    $sqlTag = "SELECT * FROM genericbase WHERE id=" . $_POST["tagid"];
    $ResultTag = mysqli_query($conn, $sqlTag);
    if ($ResultTag == null || mysqli_num_rows($ResultTag) == 0) {
        echo "<p>Tag bulunamadı!</p>";
        return;
    }
    $RowTag = mysqli_fetch_assoc($ResultTag);

    $Tag = $RowTag["tag"];

    if ($Tag == "div") {
        baseTagDeleteBlock($RowTag, $conn);
    } else {
        baseTagDeleteSingle($RowTag, $conn);
    }

    $checkResult = baseTagOrderCheck($conn);
    if ($checkResult != "ok") {
        echo $checkResult;
        return;
    }
}

function baseTagDeleteSingle($RowTag, $conn)
{
    /*id ile tagi base tablosundan siliyoruz*/
    $sqlDeleteTag = "DELETE FROM genericbase WHERE id=" . $RowTag["id"];

    if (!mysqli_query($conn, $sqlDeleteTag)) {
        echo "Tag silinirken hata oluştu!";
        return;
    }

    /*sıra numarası tag'den büyük olan tüm elemanların sıraları birer azaltılıyor*/
    $sqlUpdateOrders =
        "UPDATE genericbase SET sira = sira-1
                        WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >" .
        $RowTag["sira"];

    if (!mysqli_query($conn, $sqlUpdateOrders)) {
        echo "Sıra numaraları güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function baseTagDeleteBlock($RowTag, $conn)
{
    /*kaynak blok kapanış tagi bulunuyor*/

    $sqlCloseTag =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND tag='/div' AND taggroupcode=" .
        $RowTag["tagGroupCode"];
    $ResultCloseTag = mysqli_query($conn, $sqlCloseTag);
    if ($ResultCloseTag == null || mysqli_num_rows($ResultCloseTag) == 0) {
        echo "<p>Target Tag bulunamadı!</p>";
        return;
    }
    $RowCloseTag = mysqli_fetch_assoc($ResultCloseTag);

    /*blok count bulunuyor*/

    $blockCount = intval($RowCloseTag["sira"]) - intval($RowTag["sira"]) + 1;

    /*blok başlangıçtan kapanışa kadar olan sıralı elemanlar siliniyor*/

    $sqlDelete =
        "DELETE FROM genericbase
                  WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >=" .
        $RowTag["sira"] .
        " AND sira <=" .
        $RowCloseTag["sira"];

    if (!mysqli_query($conn, $sqlDelete)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    /*blok bitişinden büyük tüm sıralar blok count kadar azaltılıyor*/

    $sqlUpdateOrders =
        "UPDATE genericbase SET sira = sira - " .
        $blockCount .
        "
                        WHERE genericgroupid=" .
        $_POST["grupid"] .
        " AND sira >" .
        $RowCloseTag["sira"];

    if (!mysqli_query($conn, $sqlUpdateOrders)) {
        echo "<p>Sıra numaraları güncellenirken hata oluştu!</p>";
        return;
    }

    echo "ok";
}

function baseTagOrderCheck($conn)
{
    //aynı sıra numarasına sahip eleman olduğunda hata veriyoruz
    $sql =
        "SELECT id, count(*) siraSayi FROM genericbase where genericgroupid=" .
        $_POST["grupid"] .
        " 
            group by sira
            having count(*)>1";
    $Result = mysqli_query($conn, $sql);

    /*if($Result==NULL||mysqli_num_rows($Result)==0)
    {
        return "Sıra kontrol sorgu hatası";
    }*/
    if ($Result == null) {
        return "Sıra kontrol sorgu hatası";
    }
    if (mysqli_num_rows($Result) > 0) {
        return "Sıra kontrol hatası";
    }

    return "ok";
}

function baseTagValueKaydet($conn)
{
    $value = str_replace("'", "''", $_POST["value"]);

    $sql =
        "UPDATE genericbase SET value = '" .
        $value .
        "' WHERE id=" .
        $_POST["baseid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Value güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function baseGrupTumuneUygula($conn)
{
    $sqlBase =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["grupid"] .
        "  ORDER BY sira";
    $ResultBase = mysqli_query($conn, $sqlBase);
    if ($ResultBase == null || mysqli_num_rows($ResultBase) == 0) {
        echo "Tag bulunamadı!";
        return;
    }

    $sqlGeneric =
        "SELECT * FROM generic WHERE genericgroupid=" .
        $_POST["grupid"] .
        "  ORDER BY sira";
    $ResultGeneric = mysqli_query($conn, $sqlGeneric);
    if ($ResultGeneric == null || mysqli_num_rows($ResultGeneric) == 0) {
        echo "Generic bulunamadı!";
        return;
    }

    $sqlElements =
        "SELECT * FROM tagelements
                    WHERE parentid IN(SELECT id FROM generic WHERE genericgroupid=" .
        $_POST["grupid"] .
        ")
                    AND type LIKE 'generic%'";
    $ResultElements = mysqli_query($conn, $sqlElements);
    if ($ResultElements == null || mysqli_num_rows($ResultElements) == 0) {
        echo "Eleman bulunamadı!";
        return;
    }

    $sqlZero =
        "UPDATE tagelements SET sira = 0 WHERE parentid IN(SELECT id FROM generic WHERE genericgroupid=" .
        $_POST["grupid"] .
        ")
                    AND type LIKE 'generic%'";

    if (!mysqli_query($conn, $sqlZero)) {
        echo "*error* Sıralar güncellenirken hata oluştu!";
        return;
    }

    //dil listesi alınıyor. text alanlar dil sayısı kadar eklenecek
    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        echo "<p>Kayıtlı dil bulunamadı!</p>";
        return;
    }

    for (
        $langArr = [];
        ($langRow = mysqli_fetch_assoc($langResult));
        $langArr[] = $langRow
    );

    //her generic elemanı için base tablosundaki gruba ait elemanlar tagelement tablosuna eklenecek
    while ($RowGeneric = mysqli_fetch_assoc($ResultGeneric)) {
        $elementOrder = 1;
        mysqli_data_seek($ResultBase, 0);

        //base elemanları, base tablosundaki sıraya göre tagelements tablosuna eklenecek
        while ($RowBase = mysqli_fetch_assoc($ResultBase)) {
            //önceki elemanlardan baseid alanı yeni yazılacak base ile eşleşen varsa value alanı yeni kayda kopyalanıyor böylece yeri değişen elemanların değerleri korunmuş olur
            //burada value alanı array olarak yaratılıyor ve langid key olarak veriliyor. insert işleminde array içinden langid'nin değeri alınıyor
            $valueArr = [];
            mysqli_data_seek($ResultElements, 0);

            while ($RowElement = mysqli_fetch_assoc($ResultElements)) {
                if (
                    $RowElement["parentid"] == $RowGeneric["id"] &&
                    $RowElement["baseid"] == $RowBase["id"]
                ) {
                    $valueArr[$RowElement["langid"]] = $RowElement["value"];
                }
            }

            if (
                $RowBase["tag"] == "img" ||
                $RowBase["tag"] == "file" ||
                $RowBase["tag"] == "a" ||
                $RowBase["tag"] == "div" ||
                $RowBase["tag"] == "/div" ||
                $RowBase["tag"] == "list" ||
                $RowBase["tag"] == "module"
            ) {
                $sqlInsert =
                    "INSERT INTO tagelements (langid,parentid,type,sira,baseid)
                            VALUES (0, " .
                    $RowGeneric["id"] .
                    ", 'generic_" .
                    $RowBase["tag"] .
                    "', " .
                    $elementOrder .
                    ", " .
                    $RowBase["id"] .
                    ")";

                if (mysqli_query($conn, $sqlInsert)) {
                    $elementOrder++;
                } else {
                    echo "*error* Generic elemanı eklenirken hata oluştu!";
                    return;
                }
            }

            if (
                $RowBase["tag"] == "textbox" ||
                $RowBase["tag"] == "textarea" ||
                $RowBase["tag"] == "span" ||
                $RowBase["tag"] == "h1" ||
                ($RowBase["tag"] == "p") | ($RowBase["tag"] == "input")
            ) {
                for ($j = 0; $j < count($langArr); $j++) {
                    if (empty($valueArr[$langArr[$j]["id"]])) {
                        $tagValue = "";
                    } else {
                        $tagValue = $valueArr[$langArr[$j]["id"]];
                    }

                    $sqlInsert =
                        "INSERT INTO tagelements (langid,parentid,type,value,sira,baseid)
                                VALUES (" .
                        $langArr[$j]["id"] .
                        ", " .
                        $RowGeneric["id"] .
                        ", 'generic_" .
                        $RowBase["tag"] .
                        "', '" .
                        $tagValue .
                        "', " .
                        $elementOrder .
                        "," .
                        $RowBase["id"] .
                        ")";

                    if (mysqli_query($conn, $sqlInsert)) {
                        $elementOrder++;
                    } else {
                        echo "*error* Generic elemanı eklenirken hata oluştu!";
                        return;
                    }
                } //for
            } //if
        } //while base
    } //while generic

    $sqlDelete =
        "DELETE FROM tagelements WHERE sira = 0 AND parentid IN(SELECT id FROM generic WHERE genericgroupid=" .
        $_POST["grupid"] .
        ")
                    AND type LIKE 'generic%'";

    if (!mysqli_query($conn, $sqlDelete)) {
        echo "*error* Elemanlar silinirken hata oluştu!";
        return;
    }

    echo "ok";
}

function genericEkle($conn)
{
    $sqlOrder =
        "SELECT MAX(sira) maxOrder FROM generic WHERE genericgroupid=" .
        $_POST["groupid"];
    $ResultOrder = mysqli_query($conn, $sqlOrder);

    if ($ResultOrder == null || mysqli_num_rows($ResultOrder) == 0) {
        $maxOrder = 0;
    } else {
        $Row = mysqli_fetch_assoc($ResultOrder);
        $maxOrder = $Row["maxOrder"];
    }

    $order = $maxOrder + 1;

    $sqlInsert =
        "INSERT INTO generic (genericgroupid,sira,isim) VALUES (" .
        $_POST["groupid"] .
        ", " .
        $order .
        ",'" .
        $_POST["isim"] .
        "')";

    if (mysqli_query($conn, $sqlInsert)) {
        $lastGenericid = mysqli_insert_id($conn);
    } else {
        echo "*error* Generic eklenirken hata oluştu!";
        return;
    }

    $sqlLang = "SELECT id FROM lang";
    $langResult = mysqli_query($conn, $sqlLang);

    if ($langResult == null || mysqli_num_rows($langResult) == 0) {
        echo "<p>Kayıtlı dil bulunamadı!</p>";
        return;
    }

    for (
        $langArr = [];
        ($langRow = mysqli_fetch_assoc($langResult));
        $langArr[] = $langRow
    );

    $sqlTemplate =
        "SELECT * FROM genericbase WHERE genericgroupid=" .
        $_POST["groupid"] .
        " ORDER BY sira";
    $ResultTemplate = mysqli_query($conn, $sqlTemplate);

    if ($ResultTemplate == null || mysqli_num_rows($ResultTemplate) == 0) {
        echo "*error* Şablon alınırken hata oluştu!";
        return;
    }

    $elementOrder = 1;
    while ($TemplateRow = mysqli_fetch_assoc($ResultTemplate)) {
        if (
            $TemplateRow["tag"] == "img" ||
            $TemplateRow["tag"] == "file" ||
            $TemplateRow["tag"] == "a" ||
            $TemplateRow["tag"] == "div" ||
            $TemplateRow["tag"] == "/div" ||
            $TemplateRow["tag"] == "list" ||
            $TemplateRow["tag"] == "module"
        ) {
            $sqlInsert =
                "INSERT INTO tagelements (langid,parentid,baseid,type,sira,parameter,value) VALUES (0, " .
                $lastGenericid .
                "," .
                $TemplateRow["id"] .
                " , 'generic_" .
                $TemplateRow["tag"] .
                "', " .
                $elementOrder .
                ",'" .
                str_replace("'", "''", $TemplateRow["parameter"]) .
                "','" .
                $TemplateRow["value"] .
                "')";

            if (mysqli_query($conn, $sqlInsert)) {
                $elementOrder++;
            } else {
                echo "*error* Generic elemanı eklenirken hata oluştu!";
                return;
            }
        }

        if (
            $TemplateRow["tag"] == "textbox" ||
            $TemplateRow["tag"] == "textarea" ||
            $TemplateRow["tag"] == "span" ||
            $TemplateRow["tag"] == "h1" ||
            $TemplateRow["tag"] == "p" ||
            $TemplateRow["tag"] == "input"
        ) {
            for ($j = 0; $j < count($langArr); $j++) {
                $sqlInsert =
                    "INSERT INTO tagelements (langid,parentid,baseid,type,sira,parameter,value) VALUES (" .
                    $langArr[$j]["id"] .
                    ", " .
                    $lastGenericid .
                    ", " .
                    $TemplateRow["id"] .
                    " ,'generic_" .
                    $TemplateRow["tag"] .
                    "', " .
                    $elementOrder .
                    ",'" .
                    str_replace("'", "''", $TemplateRow["parameter"]) .
                    "','" .
                    $TemplateRow["value"] .
                    "')";

                if (mysqli_query($conn, $sqlInsert)) {
                    $elementOrder++;
                } else {
                    echo "*error* Generic elemanı eklenirken hata oluştu!";
                    return;
                }
            }
        }
    }

    echo "ok";
    //getGenericList($groupid,$conn);
}

function LoadGenericGroup($conn)
{
    echo "<div id=\"0_gen\" class=\"divTag\" style=\"height:2.2em;\" onclick=\"genericEklePop(" .
        $_POST["groupid"] .
        ");\">";

    echo "<span class=\"spTagName\">+ Ekle</span>";

    echo "</div>";

    $sql =
        "SELECT * FROM generic WHERE genericgroupid=" .
        $_POST["groupid"] .
        " ORDER BY sira DESC";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<p>Generic bulunamadı!</p>";
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo "<div id=\"" .
            $Row["id"] .
            "_gen\" class=\"divTag\" onclick=\"ShowGenericDetail(" .
            $Row["genericgroupid"] .
            "," .
            $Row["id"] .
            "," .
            $Row["sira"] .
            ");\">";

        echo "<span class=\"spTagName\">" . $Row["isim"] . "</span>";

        echo "</div>";
    }
}

function ShowGenericDetail($conn)
{
    $sql = "SELECT * FROM generic WHERE id=" . $_POST["id"];
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<p>Generic bulunamadı!</p>";
    }

    $Row = mysqli_fetch_assoc($Result);

    echo "<div>";
    echo "<div class=\"divStdGiris\">";

    echo "<span>İsim:</span>";
    echo "<input id=\"genIsim\" type=\"text\" value=\"" .
        $Row["isim"] .
        "\" />";

    echo "</div>";

    echo "<div class=\"divStdGiris\">";

    echo "<span>Url Name:</span>";
    echo "<input id=\"genUrlName\" type=\"text\" value=\"" .
        $Row["urlname"] .
        "\" />";

    echo "</div>";

    echo "</div>";

    echo "<div>";
    echo "<div class=\"divStdGiris\">";

    echo "<input type=\"button\" value=\"Yukarı\" onclick=\"GenericUp(" .
        $Row["genericgroupid"] .
        "," .
        $Row["id"] .
        "," .
        $Row["sira"] .
        ");\"  />";
    echo "<input type=\"button\" value=\"Aşağı\" onclick=\"GenericDown(" .
        $Row["genericgroupid"] .
        "," .
        $Row["id"] .
        "," .
        $Row["sira"] .
        ");\" />";

    echo "<span>Sıra:</span>";
    echo "<span id=\"spOrder\">" . $Row["sira"] . "</span>";

    echo "</div>";

    echo "<div class=\"divStdGiris\">";
    echo getMasterTargetSelectGeneric(
        $Row["id"],
        $Row["masterid"],
        $Row["targetid"],
        $conn
    );
    echo "</div>";

    echo "</div>";

    echo "<div>";
    echo "<div class=\"divStdGiris\">";

    echo "<span>Tarih:</span>";
    echo "<input id=\"genTarih\" type=\"text\" value=\"" .
        date_format(
            date_create_from_format("Y-m-d H:i:s", $Row["tarih"]),
            "d.m.Y"
        ) .
        "\" />";
    echo "<input id=\"genSaat\" type=\"text\" value=\"" .
        date_format(
            date_create_from_format("Y-m-d H:i:s", $Row["tarih"]),
            "H:i"
        ) .
        "\" />";

    echo "<input type=\"button\" value=\"Seç\" onclick=\"displayDatePicker('genTarih');\"  />";

    echo "</div>";
    echo "</div>";

    $sqlElements =
        " SELECT tagelements.id, lang.id langid, lang.name dil, type, parameter, value, sira, baseid, parentid
                    FROM tagelements
                    LEFT JOIN lang ON lang.id=tagelements.langid

                    WHERE type LIKE 'generic_%' AND parentid=" .
        $_POST["id"] .
        " ORDER BY sira";
    $elementsResult = mysqli_query($conn, $sqlElements);

    if ($elementsResult == null || mysqli_num_rows($elementsResult) == 0) {
        echo "<p>Eleman bulunamadı</p>";
        return;
    }

    $baseid = "";
    $rowOpen = false;

    while ($elementRow = mysqli_fetch_assoc($elementsResult)) {
        if ($elementRow["langid"] == 0) {
            if ($rowOpen) {
                echo "</div>"; //divRow

                $rowOpen = false;
            }

            if ($elementRow["type"] == "generic_div") {
                echo '<div id="headerTag_' .
                    $elementRow["id"] .
                    '" class="baseHeader" onclick="genericTagSec(' .
                    $elementRow["id"] .
                    ",0," .
                    $elementRow["baseid"] .
                    "," .
                    $elementRow["parentid"] .
                    ');">';
                echo "<span>" .
                    getGenericTagHeader(
                        $Row["genericgroupid"],
                        $elementRow["baseid"],
                        "Div"
                    ) .
                    '</span>
                      </div>';

                echo '<div id="genTag_' .
                    $elementRow["id"] .
                    '" class="baseTagBig" >';
            }
            if ($elementRow["type"] == "generic_/div") {
                echo "</div>";
            }

            if ($elementRow["type"] == "generic_img") {
                echo '<div id="headerTag_' .
                    $elementRow["id"] .
                    '" class="baseHeader" onclick="genericTagSec(' .
                    $elementRow["id"] .
                    ",0," .
                    $elementRow["baseid"] .
                    "," .
                    $elementRow["parentid"] .
                    ');">';
                echo "<span>" .
                    getGenericTagHeader(
                        $Row["genericgroupid"],
                        $elementRow["baseid"],
                        "Img"
                    ) .
                    '</span>
                      </div>';

                echo '<div id="genTag_' .
                    $elementRow["id"] .
                    '" class="baseTagSmall" >';
                /*/ işareti içeren value alanı varsa klasör seçilecek*/

                $pathArr = explode("/", $elementRow["value"]);

                $files = scandir("../img");

                echo "<img id=\"" . $elementRow["id"] . "_img\" />";
                echo "<input id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" type=\"hidden\" value=\"" .
                    $elementRow["value"] .
                    "\" />";

                echo "<label>img/</label>";

                echo "<div id=\"divSelects_" .
                    $elementRow["id"] .
                    "\" class=\"divSelects\">";

                echo "<select onchange='baseImgOnchange(this);'>";
                echo "<option></option>";

                foreach ($files as $folder) {
                    if ($folder == "Thumbs.db") {
                        continue;
                    }

                    if ($folder == "." || $folder == "..") {
                        continue;
                    }

                    if (count($pathArr) > 0 && $pathArr[0] == $folder) {
                        echo "<option selected='selected'>" .
                            $folder .
                            "</option>";
                    } else {
                        echo "<option>" . $folder . "</option>";
                    }
                }

                echo "</select>";

                if (count($pathArr) > 1) {
                    for ($i = 1; $i < count($pathArr); $i++) {
                        $pathString = "../img";
                        for ($j = 0; $j < $i; $j++) {
                            $pathString .= "/" . $pathArr[$j];
                        }

                        $files = scandir($pathString);

                        echo "<select onchange='baseImgOnchange(this);'>";
                        echo "<option></option>";

                        foreach ($files as $folder) {
                            if ($folder == "Thumbs.db") {
                                continue;
                            }

                            if ($folder == "." || $folder == "..") {
                                continue;
                            }

                            if (
                                count($pathArr) > 0 &&
                                $pathArr[$i] == $folder
                            ) {
                                echo "<option selected='selected'>" .
                                    $folder .
                                    "</option>";
                            } else {
                                echo "<option>" . $folder . "</option>";
                            }
                        }

                        echo "</select>";
                    }
                }

                echo "</div>"; //divselects

                echo "</div>"; //base tag
            }
        } else {
            //langid!=0

            if ($baseid != "" && $baseid != $elementRow["baseid"] && $rowOpen) {
                echo "</div>"; //divRow

                $rowOpen = false;
            }

            $baseid = $elementRow["baseid"];

            if ($elementRow["type"] == "generic_h1") {
                if (!$rowOpen) {
                    $rowOpen = true;

                    echo '<div id="headerTag_' .
                        $elementRow["id"] .
                        '" class="baseHeader" onclick="genericTagSec(' .
                        $elementRow["id"] .
                        "," .
                        $elementRow["langid"] .
                        "," .
                        $elementRow["baseid"] .
                        "," .
                        $elementRow["parentid"] .
                        ');">';
                    echo "<span>" .
                        getGenericTagHeader(
                            $Row["genericgroupid"],
                            $elementRow["baseid"],
                            "H1"
                        ) .
                        '</span>
                          </div>';

                    echo '<div id="genTag_' .
                        $elementRow["id"] .
                        '" class="divTagRow" >';
                }

                echo "<div class=\"divTagValueInline\">";

                echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                    $elementRow["dil"] .
                    "</span></div> </div>";

                $value = htmlspecialchars($elementRow["value"]);

                echo "<div id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" class=\"divTextValue\" contenteditable=\"true\" ";

                if ($_SESSION["PasteWithStyle"] == false) {
                    echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
                }

                echo ">" . $value . "</div>";

                echo "</div>";
            }

            if ($elementRow["type"] == "generic_span") {
                if (!$rowOpen) {
                    $rowOpen = true;

                    echo '<div id="headerTag_' .
                        $elementRow["id"] .
                        '" class="baseHeader" onclick="genericTagSec(' .
                        $elementRow["id"] .
                        "," .
                        $elementRow["langid"] .
                        "," .
                        $elementRow["baseid"] .
                        "," .
                        $elementRow["parentid"] .
                        ');">';
                    echo "<span>" .
                        getGenericTagHeader(
                            $Row["genericgroupid"],
                            $elementRow["baseid"],
                            "Span"
                        ) .
                        '</span>
                          </div>';

                    echo '<div id="genTag_' .
                        $elementRow["id"] .
                        '" class="divTagRow" >';
                }

                echo "<div class=\"divTagValueInline\">";

                echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                    $elementRow["dil"] .
                    "</span></div> </div>";
                echo "<div class=\"divTagBtns\"><input type='button' value='Raw' onclick='convertToRaw(this);'>
                        <input type='button' value='Formatted' onclick='convertToFormatted(this);'></div>";

                $value = htmlspecialchars($elementRow["value"]);

                echo "<div id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" class=\"divTextValue\" contenteditable=\"true\" ";

                if ($_SESSION["PasteWithStyle"] == false) {
                    echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
                }

                echo ">" . $value . "</div>";

                echo "</div>";
            }

            if ($elementRow["type"] == "generic_textbox") {
                if (!$rowOpen) {
                    $rowOpen = true;

                    echo '<div id="headerTag_' .
                        $elementRow["id"] .
                        '" class="baseHeader" onclick="genericTagSec(' .
                        $elementRow["id"] .
                        "," .
                        $elementRow["langid"] .
                        "," .
                        $elementRow["baseid"] .
                        "," .
                        $elementRow["parentid"] .
                        ');">';
                    echo "<span>" .
                        getGenericTagHeader(
                            $Row["genericgroupid"],
                            $elementRow["baseid"],
                            "Textbox"
                        ) .
                        '</span>
                          </div>';

                    echo '<div id="genTag_' .
                        $elementRow["id"] .
                        '" class="divTagRow" >';
                }

                echo "<div class=\"divTagValueInline\">";

                echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                    $elementRow["dil"] .
                    "</span></div> </div>";

                $value = htmlspecialchars($elementRow["value"]);

                echo "<div id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" class=\"divTextValue\" contenteditable=\"true\" ";

                if ($_SESSION["PasteWithStyle"] == false) {
                    echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
                }

                echo ">" . $value . "</div>";

                echo "</div>";
            }

            if ($elementRow["type"] == "generic_textarea") {
                if (!$rowOpen) {
                    $rowOpen = true;

                    echo '<div id="headerTag_' .
                        $elementRow["id"] .
                        '" class="baseHeader" onclick="genericTagSec(' .
                        $elementRow["id"] .
                        "," .
                        $elementRow["langid"] .
                        "," .
                        $elementRow["baseid"] .
                        "," .
                        $elementRow["parentid"] .
                        ');">';
                    echo "<span>" .
                        getGenericTagHeader(
                            $Row["genericgroupid"],
                            $elementRow["baseid"],
                            "Textarea"
                        ) .
                        '</span>
                          </div>';

                    echo '<div id="genTag_' .
                        $elementRow["id"] .
                        '" class="divTagRowBig" >';
                }

                echo "<div class=\"divTagValueInlineBig\">";

                echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                    $elementRow["dil"] .
                    "</span></div> </div>";

                $value = htmlspecialchars($elementRow["value"]);

                echo "<div id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" class=\"divTextValueBig\" contenteditable=\"true\" ";

                if ($_SESSION["PasteWithStyle"] == false) {
                    echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
                }

                echo ">" . $value . "</div>";

                echo "</div>";
            }

            if ($elementRow["type"] == "generic_p") {
                if (!$rowOpen) {
                    $rowOpen = true;

                    echo '<div id="headerTag_' .
                        $elementRow["id"] .
                        '" class="baseHeader" onclick="genericTagSec(' .
                        $elementRow["id"] .
                        "," .
                        $elementRow["langid"] .
                        "," .
                        $elementRow["baseid"] .
                        "," .
                        $elementRow["parentid"] .
                        ');">';
                    echo "<span>" .
                        getGenericTagHeader(
                            $Row["genericgroupid"],
                            $elementRow["baseid"],
                            "P"
                        ) .
                        '</span>
                          </div>';

                    echo '<div id="genTag_' .
                        $elementRow["id"] .
                        '" class="divTagRow" >';
                }

                echo "<div class=\"divTagValueInline\">";

                echo "<div class=\"divTagLangWrapper\"> <div class=\"divTagLang\"><span>" .
                    $elementRow["dil"] .
                    "</span></div> </div>";
                echo "<div class=\"divTagBtns\"><input type='button' value='Raw' onclick='convertToRaw(this);'>
                        <input type='button' value='Formatted' onclick='convertToFormatted(this);'></div>";

                $value = htmlspecialchars($elementRow["value"]);

                echo "<div id=\"" .
                    $elementRow["id"] .
                    "_tagelement\" class=\"divTextValue\" contenteditable=\"true\" ";

                if ($_SESSION["PasteWithStyle"] == false) {
                    echo "onpaste=\"OnPaste_StripFormatting(this, event);\" ";
                }

                echo ">" . $value . "</div>";

                echo "</div>";
            }
        }
    } //while
}

function getGenericTagHeader($genericgroupid, $baseid, $type)
{
    $header = $type;

    /////////////////tarif

    if ($genericgroupid == "7") {
        if ($baseid == "29") {
            $header = "Yemek Adı";
        }

        if ($baseid == "38") {
            $header = "Malzeme Başlık";
        }

        if ($baseid == "39") {
            $header = "Malzeme Yazı";
        }

        if ($baseid == "40") {
            $header = "Yapılış Başlık";
        }

        if ($baseid == "41") {
            $header = "Yapılış Yazı";
        }

        if ($baseid == "46") {
            $header = "Ürün Resim";
        }

        if ($baseid == "65") {
            $header = "Özellik 1";
        }
        if ($baseid == "66") {
            $header = "Özellik 2";
        }
        if ($baseid == "67") {
            $header = "Özellik 3";
        }
        if ($baseid == "68") {
            $header = "Özellik 4";
        }
        if ($baseid == "77") {
            $header = "Özellik 5";
        }
        if ($baseid == "78") {
            $header = "Özellik 6";
        }
        if ($baseid == "79") {
            $header = "Özellik 7";
        }
        if ($baseid == "80") {
            $header = "Özellik 8";
        }
        if ($baseid == "87") {
            $header = "Kalori Başlık";
        }
        if ($baseid == "88") {
            $header = "Kalori Miktar";
        }
        if ($baseid == "91") {
            $header = "Tarif Resim";
        }
        if ($baseid == "94") {
            $header = "Video Başlık";
        }
        if ($baseid == "97") {
            $header = "Video Resim";
        }
        if ($baseid == "98") {
            $header = "Tarif Süresi";
        }
        if ($baseid == "99") {
            $header = "Video Link";
        }
    }

    /////////////////tarif bitti

    //// reklam kampanyası
    if ($genericgroupid == "8") {
        if ($baseid == "102") {
            $header = "Video Link";
        }
        if ($baseid == "109") {
            $header = "Kampanya Resim";
        }
        if ($baseid == "110") {
            $header = "Kampanya Başlık";
        }
    }
    //// reklam kampanyası    bitti
    ///
    ///
    if ($genericgroupid == "9") {
        if ($baseid == "113") {
            $header = "Video Link";
        }
        if ($baseid == "120") {
            $header = "Resim";
        }
        if ($baseid == "121") {
            $header = "Başlık";
        }
    }
    ///
    /// ///  basın bülteni
    if ($genericgroupid == "10") {
        if ($baseid == "130") {
            $header = "Bülten Görsel";
        }
        if ($baseid == "131") {
            $header = "Bülten Başlık";
        }
        if ($baseid == "132") {
            $header = "Bülten Text";
        }
    }
    //// basın bülteni bitti
    ///
    /// ///  basın bülteni
    if ($genericgroupid == "11") {
        if ($baseid == "140") {
            $header = "Başlık";
        }
        if ($baseid == "141") {
            $header = "Dosya Adı";
        }
    }
    //// basın bülteni bitti

    return $header;
}

function getMasterTargetSelectGeneric(
    $genericid,
    $masterid,
    $targetid,
    $connection
) {
    $selectString = "";

    $selectString = $selectString . "<label>Master: </label>";

    $sql = "SELECT * FROM generic WHERE id<>" . $genericid;
    $Result = mysqli_query($connection, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
    }

    $selectString =
        $selectString . "<select id=\"" . $genericid . "_genericmaster\">";

    $selectString = $selectString . "<option></option>";

    while ($Row = mysqli_fetch_assoc($Result)) {
        if ($masterid != null && $masterid == $Row["id"]) {
            $selectString =
                $selectString .
                "<option value=\"" .
                $Row["id"] .
                "\" selected=\"selected\">" .
                $Row["isim"] .
                "</option>";
        } else {
            $selectString =
                $selectString .
                "<option value=\"" .
                $Row["id"] .
                "\">" .
                $Row["isim"] .
                "</option>";
        }
    }

    $selectString = $selectString . "</select></br>";

    ////

    $selectString = $selectString . "<label>Target: </label>";

    mysqli_data_seek($Result, 0);

    $selectString =
        $selectString . "<select id=\"" . $genericid . "_generictarget\">";

    $selectString = $selectString . "<option></option>";

    while ($Row = mysqli_fetch_assoc($Result)) {
        if ($targetid != null && $targetid == $Row["id"]) {
            $selectString =
                $selectString .
                "<option value=\"" .
                $Row["id"] .
                "\" selected=\"selected\">" .
                $Row["isim"] .
                "</option>";
        } else {
            $selectString =
                $selectString .
                "<option value=\"" .
                $Row["id"] .
                "\">" .
                $Row["isim"] .
                "</option>";
        }
    }

    $selectString = $selectString . "</select>";

    return $selectString;
}

function SaveGenericContent($conn)
{
    $sql =
        "UPDATE generic SET
            isim = '" .
        $_POST["isim"] .
        "',
            urlname= '" .
        $_POST["urlName"] .
        "',
            masterid= '" .
        $_POST["masterid"] .
        "',
            targetid= '" .
        $_POST["targetid"] .
        "',
            tarih= '" .
        $_POST["date"] .
        "'
            WHERE id=" .
        $_POST["genericid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Generic güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function GenericElementsUpdate($conn)
{
    $value = str_replace("'", "''", $_POST["value"]);

    $value = htmlspecialchars_decode($value);

    if (substr($value, strlen($value) - 4) == "<br>") {
        //textin sonunda br istiyorsak, en sonda bir boşluk bırakıyoruz
        $value = substr($value, 0, strlen($value) - 4);
    }

    $sql =
        "UPDATE tagelements SET value = '" .
        $value .
        "' WHERE id=" .
        $_POST["elementid"];

    if (!mysqli_query($conn, $sql)) {
        echo "*error* Element güncellenirken hata oluştu!";
        return;
    }

    echo "ok";
}

function GenericUp($conn)
{
    $sql =
        "SELECT MAX(sira) maxOrder FROM generic WHERE genericgroupid=" .
        $_POST["groupid"];
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        $maxOrder = 0;
    } else {
        $Row = mysqli_fetch_assoc($Result);
        $maxOrder = $Row["maxOrder"];
    }

    if ($_POST["order"] == $maxOrder) {
        echo "ok";
        return;
    }

    $sqlOrder1 =
        "UPDATE generic SET sira=sira-1 WHERE sira = " .
        $_POST["order"] .
        "+1 AND genericgroupid=" .
        $_POST["groupid"];

    if (!mysqli_query($conn, $sqlOrder1)) {
        echo "*error* Generic kaydırılırken hata oluştu!";
        return;
    }

    $sqlOrder2 =
        "UPDATE generic SET sira=sira+1 WHERE id=" . $_POST["genericid"];

    if (mysqli_query($conn, $sqlOrder2)) {
        echo "ok";
        return;
    } else {
        echo "*error* Generic kaydırılırken hata oluştu!";
        return;
    }
}

function GenericDown($conn)
{
    if ($_POST["order"] == "1") {
        return;
    }

    $sqlOrder1 =
        "UPDATE generic SET sira=sira+1 WHERE sira = " .
        $_POST["order"] .
        "-1 AND genericgroupid=" .
        $_POST["groupid"];

    if (!mysqli_query($conn, $sqlOrder1)) {
        echo "*error* Generic kaydırılırken hata oluştu!";
        return;
    }

    $sqlOrder2 =
        "UPDATE generic SET sira=sira-1 WHERE id=" . $_POST["genericid"];

    if (mysqli_query($conn, $sqlOrder2)) {
        echo "ok";
    } else {
        echo "*error* Generic kaydırılırken hata oluştu!";
        return;
    }
}

function GenericDelete($conn)
{
    $sqlOrder =
        "UPDATE generic SET sira=sira-1 WHERE sira > " .
        $_POST["order"] .
        " AND genericgroupid=" .
        $_POST["groupid"];

    if (!mysqli_query($conn, $sqlOrder)) {
        echo "*error* Generic silinirken hata oluştu!";
        return;
    }

    //$sqlDeleteElements = "DELETE FROM tagelements WHERE type LIKE 'generic_%' AND parentid IN
    //					 (SELECT id FROM  generic WHERE genericgroupid=".$genericgroupid.")";

    $sqlDeleteElements =
        "DELETE FROM tagelements WHERE type LIKE 'generic_%' AND parentid=" .
        $_POST["genericid"];

    if (mysqli_query($conn, $sqlDeleteElements)) {
    } else {
        echo "*error* Tagelement silinirken hata oluştu!";
        return;
    }

    $sqlDeleteGeneric = "DELETE FROM generic WHERE id=" . $_POST["genericid"];

    if (mysqli_query($conn, $sqlDeleteGeneric)) {
        echo "ok";
        return;
    } else {
        echo "*error* Generic silinirken hata oluştu!";
        return;
    }
}

function getSingleFolderSelect()
{
    $baseDir = dirname(__DIR__);
    //echo $baseDir;
    //echo " ". rtrim($_POST["path"],"/");
    //return;

    if (!is_dir($baseDir . "/img/" . rtrim($_POST["path"], "/"))) {
        echo "loadimg";
        return;
    }

    $files = scandir($baseDir . "/img/" . rtrim($_POST["path"], "/"));

    //echo "<select onchange='baseImgOnchange(this);'>";
    echo "<option></option>";

    foreach ($files as $folder) {
        if ($folder == "Thumbs.db") {
            continue;
        }

        if ($folder == "." || $folder == "..") {
            continue;
        }

        echo "<option>" . $folder . "</option>";
    }

    //echo "</select>";
}
