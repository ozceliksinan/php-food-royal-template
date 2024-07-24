<?php
session_start();
include "Genel.php";

if (isset($_POST["call"])) {
    $callFunction = $_POST["call"];
} else {
    $callFunction = "";
}

if (isset($_POST["loadParam"])) {
    $loadParam = $_POST["loadParam"];
} else {
    $loadParam = "";
}

if ($callFunction == "getGenericContentIPTAL") {
    //tüm işlemler getgenerics parametreleriyle yapılabilir
    getGenericContent($loadParam, "", $_POST["referenceid"], $conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "getGenerics") {
    getGenerics($loadParam, $_POST["referenceid"], $conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "idList") {
    getHtmlids($_POST["pageName"], $conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "setLanguage") {
    setLanguage();
    return;
}

//doğrudan tagtype kontrolüne geçmek için yükle.php çağırılırken Htmlid olarak -1 veriyoruz
$Htmlid = $_POST["Htmlid"];

$sqlTag = "SELECT * FROM tags WHERE htmlid='" . $Htmlid . "'";

$tagResult = mysqli_query($conn, $sqlTag);

if ($tagResult == null || mysqli_num_rows($tagResult) == 0) {
    if (strpos($loadParam, "tagType=") === false) {
        echo "*error* Tag bilgisi alınamadı.\n htmlid=" . $Htmlid;
        return;
    }
}

$tagRow = mysqli_fetch_assoc($tagResult);

if ($tagRow) {
    $tagid = $tagRow["id"];
    $contentType = $tagRow["contenttype"];
    $referenceid = $tagRow["referenceid"];
    $tagparam = $tagRow["parameter"];
} else {
    // Handle the case where $tagRow is null
    $tagid = null;
    $contentType = null;
    $referenceid = null;
    $tagparam = null;
    // You can also add some error handling logic here if needed
}

if (strpos($loadParam, "tagType=") !== false) {
    $paramsArr = explode("!", $loadParam);

    for ($i = 0; $i < count($paramsArr); $i++) {
        if (strpos($paramsArr[$i], "tagType=") !== false) {
            $typeArr = explode("=", $paramsArr[$i]);
            $contentType = $typeArr[1];
        }
        if (strpos($paramsArr[$i], "referenceid=") !== false) {
            $refArr = explode("=", $paramsArr[$i]);
            $referenceid = $refArr[1];
        }
    }
}

$tableName = getTableName($contentType);
if ($tableName == "error") {
    echo "*error* Kayıt yüklenirken hata oluştu! (table name)";
    return;
}

if ($tableName == "modules") {
    getModule($tableName, $tagid, $conn);
} elseif ($tableName == "genericgroup") {
    getGenerics($loadParam, $referenceid, $conn);
} elseif ($tableName == "subpage") {
    getSubpage($referenceid, $conn);
} elseif ($tableName == "list") {
    getList($referenceid, $conn);
} elseif ($tableName == "img") {
    getElementValue($tableName, $tagid, $tagparam, $conn);
} else {
    getContent($tableName, $tagid, $conn);
}

mysqli_close($conn);

function setLanguage()
{
    $_SESSION["Langid"] = $_POST["Langid"];
}

function getHtmlids($pageName, $conn)
{
    $sqlPageid = "SELECT id FROM pages WHERE file='" . $pageName . "'";
    $ResultPageid = mysqli_query($conn, $sqlPageid);

    if ($ResultPageid == null || mysqli_num_rows($ResultPageid) == 0) {
        echo "Sayfa bulunamadı!";
        return;
    }

    $RowPageid = mysqli_fetch_assoc($ResultPageid);

    //Sayaç Kayıt Ekleme Bölümü
    /*$sqlCounter = "INSERT INTO counter (pageid,caller) VALUES ('".$RowPageid["id"]."','".$_SERVER['REMOTE_ADDR']."')";

    if(!mysqli_query($conn,$sqlCounter))
    {
        echo "*error* Sayaç kaydedilirken hata oluştu!";
        return;
    }*/

    $sql =
        "SELECT htmlid FROM tags WHERE pageid=" .
        $RowPageid["id"] .
        " ORDER BY sira";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo ",";
        return;
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo "," . $Row["htmlid"];
    }
}

function getTableName($type)
{
    if ($type == "text") {
        return "texts";
    }

    if ($type == "value") {
        return "vals";
    }

    if ($type == "module") {
        return "modules";
    }

    if ($type == "generic") {
        return "genericgroup";
    }

    if ($type == "subpage") {
        return "subpage";
    }

    if ($type == "list") {
        return "list";
    }

    if ($type == "img") {
        return "img";
    }

    return "error";
}

/*function getContent($tableName,$tagid,$conn){ //ORJİNAL

	$sqlContent ="SELECT content FROM ". $tableName ." WHERE tagid=".$tagid ." AND langid=".$_SESSION["Langid"] ;

	$contentResult = mysqli_query($conn,$sqlContent);


	if($contentResult==NULL||mysqli_num_rows($contentResult)==0)
	{
		echo "*error* Content alınamadı.";
		return;
	}

	$contentRow = mysqli_fetch_assoc($contentResult);
	$content = $contentRow["content"];
	echo $content;

}*/

function getContent($tableName, $tagid, $conn)
{
    $sqlContent =
        "SELECT htmlid, content FROM " .
        $tableName .
        " LEFT JOIN tags ON tags.id=" .
        $tableName .
        ".tagid WHERE tagid=" .
        $tagid .
        " AND langid=" .
        $_SESSION["Langid"];

    $contentResult = mysqli_query($conn, $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);
    $content = $contentRow["content"];

    if (strpos($contentRow["htmlid"], "_videoembedded") !== false) {
        if ($content != "" && $content != "<br>") {
            echo '<iframe src="https://www.youtube.com/embed/' .
                $content .
                '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

            return;
        } else {
            echo '<img src="img/urun_video.png">';

            return;
        }
    }

    echo $content;
}

function getElementValue($tableName, $tagid, $tagparam, $conn)
{
    $sqlContent = "SELECT value FROM tagelements WHERE parentid=" . $tagid;

    $contentResult = mysqli_query($conn, $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);
    $content = $contentRow["value"];

    if ($tableName == "img") {
        $onclick = "";
        $alt = "";

        $paramsArr = explode("|", $tagparam);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "onclick=") !== false) {
                $onclickArr = explode("=", $paramsArr[$i]);
                $onclick = $onclickArr[1];
            }
            if (strpos($paramsArr[$i], "alt text=") !== false) {
                $altArr = explode("=", $paramsArr[$i]);
                $alt = $altArr[1];
            }
        }

        $content = $content . "|" . $onclick . "|" . $alt;
    }

    echo $content;
}

function getModule($tableName, $tagid, $conn)
{
    $sqlContent = "SELECT * FROM " . $tableName . " WHERE tagid=" . $tagid;

    $contentResult = mysqli_query($conn, $sqlContent);

    if ($contentResult == null || mysqli_num_rows($contentResult) == 0) {
        echo "*error* Content alınamadı.";
        return;
    }

    $contentRow = mysqli_fetch_assoc($contentResult);

    //$script = str_replace("*parameter*", $contentRow["parameter"] , $contentRow["script"] );
    //$style = $contentRow["style"];

    //$html = "<link rel=\"stylesheet\" type=\"text/css\" href=\"..".$GLOBALS["RootFolder"]."/CSS/".$contentRow["type"]. ".css\" />";
    $html =
        "<link rel=\"stylesheet\" type=\"text/css\" href=\"CSS/" .
        $contentRow["type"] .
        ".css\" />";
    $html .=
        "<input type=\"hidden\" name=\"moduleParam\" value=\"" .
        $contentRow["parameter"] .
        "\" />";
    $html .=
        "<input type=\"hidden\" name=\"moduleid\" value=\"" .
        $contentRow["id"] .
        "\" />" .
        $contentRow["innerhtml"]; //birden fazla modül aynı sayfada olunca sorun çıkar, name:moduleid bölümünü düzenle

    //$html .= "<script type=\"text/javascript\" src=\"JS/". $contentRow["type"]. ".js\"></script>";

    $content = $contentRow["type"] . "_" . $html;
    echo $content;
}

function getGenerics($loadParam, $referenceid, $conn)
{
    $sqlGroup = "SELECT * FROM genericgroup WHERE id=" . $referenceid;
    $groupResult = mysqli_query($conn, $sqlGroup);

    if ($groupResult == null || mysqli_num_rows($groupResult) == 0) {
        echo "*error* Grup alınamadı.";
        return;
    }
    $groupRow = mysqli_fetch_assoc($groupResult);

    //$groupRow["isim"]

    $targetClass = "";
    $nameOnly = false;
    $firstElement = false;
    $firstDiv = false;
    $sira = "";
    $baseStart = ""; //base start ve end arasındaki tagler yazdırılır, geri kalanı echo'ya dahil edilmez
    $baseEnd = "";
    $noText = false;

    $sqlGeneric = "SELECT * FROM generic WHERE genericgroupid=" . $referenceid;

    if (!empty($loadParam)) {
        $paramsArr = explode("!", $loadParam);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "type:") !== false) {
                $sqlGeneric =
                    $sqlGeneric .
                    " AND parametre LIKE '%" .
                    $paramsArr[$i] .
                    "%' ";
            }
            if (strpos($paramsArr[$i], "targetClass=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $targetClass = $classArr[1];
            }
            if (strpos($paramsArr[$i], "targetid=") !== false) {
                $idArr = explode("=", $paramsArr[$i]);
                $sqlGeneric = $sqlGeneric . " AND id = " . $idArr[1] . " ";
            }
            if (strpos($paramsArr[$i], "masterid=") !== false) {
                $idArr = explode("=", $paramsArr[$i]);
                $sqlGeneric =
                    $sqlGeneric . " AND masterid = " . $idArr[1] . " ";
            }
            if (strpos($paramsArr[$i], "filter:") !== false) {
                $sqlGeneric =
                    $sqlGeneric .
                    " AND parametre LIKE '%" .
                    $paramsArr[$i] .
                    "%' ";
            }

            if (strpos($paramsArr[$i], "limit:") !== false) {
                $sqlGeneric = $sqlGeneric . " ORDER BY sira DESC";

                $limitArr = explode(":", $paramsArr[$i]);

                $sqlGeneric = $sqlGeneric . " LIMIT " . $limitArr[1] . " ";
            }
            if (strpos($paramsArr[$i], "offset:") !== false) {
                //önce limit parametre olarak gelmeli

                $offsetArr = explode(":", $paramsArr[$i]);

                $sqlGeneric = $sqlGeneric . " OFFSET " . $offsetArr[1] . " ";
            }
            if (strpos($paramsArr[$i], "nameOnly") !== false) {
                $nameOnly = true;
            }
            if (strpos($paramsArr[$i], "firstElement") !== false) {
                $firstElement = true;
            }
            if (strpos($paramsArr[$i], "firstDiv") !== false) {
                $firstDiv = true;
            }
            if (strpos($paramsArr[$i], "exclude:") !== false) {
                $exArr = explode(":", $paramsArr[$i]);

                $sqlGeneric = $sqlGeneric . " AND id <> " . $exArr[1] . " ";
            }
            if (strpos($paramsArr[$i], "sira:") !== false) {
                $siraArr = explode(":", $paramsArr[$i]);

                $sira = $siraArr[1];
            }
            if (strpos($paramsArr[$i], "baseStart:") !== false) {
                $baseArr = explode(":", $paramsArr[$i]);

                $baseStart = $baseArr[1];
            }
            if (strpos($paramsArr[$i], "baseEnd:") !== false) {
                $baseArr = explode(":", $paramsArr[$i]);

                $baseEnd = $baseArr[1];
            }
            if (strpos($paramsArr[$i], "idlist=") !== false) {
                $idArr = explode("=", $paramsArr[$i]);
                $sqlGeneric = $sqlGeneric . " AND id IN( " . $idArr[1] . ") ";
            }
            if (strpos($paramsArr[$i], "notext") !== false) {
                $noText = true;
            }
        }
    }

    if (
        strpos($sqlGeneric, "LIMIT") == false &&
        strpos($sqlGeneric, "OFFSET") == false
    ) {
        $sqlGeneric = $sqlGeneric . " ORDER BY sira ASC";
    }

    $genericResult = mysqli_query($conn, $sqlGeneric);

    if ($genericResult == null || mysqli_num_rows($genericResult) == 0) {
        //echo "*error* Generic alınamadı."; //loadparam ile portfolyoda kategori seçerken sonuç gelmezse hata veriyordu kaldırdım
        return;
    }

    while ($genericRow = mysqli_fetch_assoc($genericResult)) {
        if ($nameOnly) {
            echo "," . $genericRow["isim"];
            continue;
        }

        $sqlElement =
            "SELECT * FROM tagelements WHERE parentid=" .
            $genericRow["id"] .
            " AND langid IN(0," .
            $_SESSION["Langid"] .
            ") ";

        $sqlElement .= " ORDER BY sira";

        //genericlerin belli elemanları listelenirken örneğin ürünün adı ve resmi alınacaksa
        //hem firstdiv hem de sıra parametresi gelebilir. böyle olursa first div için döngü başlatılır,
        //div kapanış tagi yazıldıktan sora sıra parametresi için getgenericcontent çalıştırılır.
        //yani ilk girişte firstdiv varsa sira parametresi çalıştırılmayacak
        if ($firstDiv == false) {
            if (!empty($sira)) {
                getGenericContent("", $sira, $genericRow["id"], $conn);
                continue;
            }
        }

        $elementResult = mysqli_query($conn, $sqlElement);

        if ($elementResult == null || mysqli_num_rows($elementResult) == 0) {
            echo "*error* Element alınamadı.";
            return;
        }

        $baseStarted = false;
        $baseEnded = false;

        while ($elementRow = mysqli_fetch_assoc($elementResult)) {
            $class = "";
            $style = "";
            $link = "";
            $addid = "";
            $typeString = "";
            $onclick = "";
            $addDataTargetid = "";
            $addDataFilter = "";
            $addGenid = "";
            $alt = "";
            $lazyLoadImg = "";

            //eğer baseStart ve end parametresi varsa döngü basestartta verilen baseid gelene kadar döngü devam ettirilecek.
            //baseStart geldikten sonra aradaki diğer elemanların da alınması için baseStarted değişkeni yaratılıyor.
            //hem baseStart dolu hem baseStarted true ise echo, değilse continue yapılacak
            //eğer baseid baseend'e eşitse baseEnded true yapılacak ve gelen tag yazdırılacak, bir sonraki döngüde baseEnded
            //true görülürse döngü break ile bitirilecek
            if ($baseStart != "") {
                if ($baseStart == $elementRow["baseid"]) {
                    $baseStarted = true;
                }

                if ($baseStarted == false) {
                    continue;
                }

                if ($baseEnded == true) {
                    break;
                }

                if ($baseEnd == $elementRow["baseid"]) {
                    $baseEnded = true;
                }
            }

            $paramsArr = explode("|", $elementRow["parameter"]);

            for ($i = 0; $i < count($paramsArr); $i++) {
                if (strpos($paramsArr[$i], "class=") !== false) {
                    $classArr = explode("=", $paramsArr[$i]);
                    $class = $classArr[1];
                }
                if (strpos($paramsArr[$i], "style=") !== false) {
                    $styleArr = explode("=", $paramsArr[$i]);
                    $style = $styleArr[1];
                }
                if (strpos($paramsArr[$i], "link=") !== false) {
                    $linkArr = explode("=", $paramsArr[$i]);
                    $link = $linkArr[1];
                }
                if (strpos($paramsArr[$i], "targetTag=") !== false) {
                    $targetArr = explode("!", $paramsArr[$i]);

                    for ($j = 0; $j < count($targetArr); $j++) {
                        if (strpos($targetArr[$j], "targetTag=") !== false) {
                            $targetTagArr = explode("=", $targetArr[$j]);
                            $targetTag = $targetTagArr[1];

                            if (strpos($link, "?") !== false) {
                                $link = $link . "&";
                            } else {
                                $link = $link . "?";
                            }

                            $link = $link . "targetTag=" . $targetTag;
                        }
                        if (strpos($targetArr[$j], "targetClass=") !== false) {
                            $targetClassArr = explode("=", $targetArr[$j]);
                            $targetClass = $targetClassArr[1];

                            $link = $link . "!targetClass=" . $targetClass;
                        }
                        if (strpos($targetArr[$j], "targetid") !== false) {
                            $link =
                                $link . "!targetid=" . $genericRow["targetid"];
                        }
                        if (strpos($targetArr[$j], "selfid") !== false) {
                            $link = $link . "!selfid=" . $genericRow["id"];
                        }
                    }
                }

                if (strpos($paramsArr[$i], "addid=") !== false) {
                    $addidArr = explode("=", $paramsArr[$i]);
                    $addid = "_" . $addidArr[1] . $genericRow["id"];
                }
                if (strpos($paramsArr[$i], "type=") !== false) {
                    $typeString = $paramsArr[$i];
                }
                if (strpos($paramsArr[$i], "onclick=") !== false) {
                    $onclick = str_replace("onclick=", "", $paramsArr[$i]);
                }
                if (strpos($paramsArr[$i], "addDataTargetid") !== false) {
                    $addDataTargetid = $genericRow["targetid"];
                }
                if (strpos($paramsArr[$i], "addDataFilter=") !== false) {
                    $addDataFilter = str_replace(
                        "addDataFilter=",
                        "",
                        $paramsArr[$i]
                    );
                }
                if (strpos($paramsArr[$i], "addGenid") !== false) {
                    $addGenid = $genericRow["id"];
                }
                if (strpos($paramsArr[$i], "alt text=") !== false) {
                    $alt = str_replace("alt text=", "", $paramsArr[$i]);
                }
                if (strpos($paramsArr[$i], "lazy_load_img") !== false) {
                    $lazyLoadImg = true;
                }
            }

            if (!empty($targetClass)) {
                $class = $class . " " . $targetClass;
                $targetClass = "";
            }

            //arapça için text alanlar style alanına ekleme
            if ($_SESSION["Langid"] == 3) {
                if (
                    $elementRow["type"] == "generic_txt" ||
                    $elementRow["type"] == "generic_textbox" ||
                    $elementRow["type"] == "generic_h1" ||
                    $elementRow["type"] == "generic_span" ||
                    $elementRow["type"] == "generic_textarea" ||
                    $elementRow["type"] == "generic_p"
                ) {
                    $style =
                        $style . "direction: rtl; unicode-bidi: plaintext;";
                }
            }

            if ($elementRow["type"] == "generic_txt") {
                echo "<label class=\"" .
                    $class .
                    "\"    style=\"" .
                    $style .
                    "\">" .
                    $elementRow["value"] .
                    "</label>";
            }
            if ($elementRow["type"] == "generic_textbox") {
                echo "<input type=\"text\" class=\"" .
                    $class .
                    "\" style=\"" .
                    $style .
                    "\" value=\"" .
                    $elementRow["value"] .
                    "\" />";
            }
            if ($elementRow["type"] == "generic_h1") {
                echo "<h1 class=\"" .
                    $class .
                    "\"    style=\"" .
                    $style .
                    "\">" .
                    $elementRow["value"] .
                    "</h1>";
            }
            if ($elementRow["type"] == "generic_span") {
                if (!empty($link)) {
                    echo "<a href=\"" . $link . "\">";
                }

                echo "<span ";

                if (!empty($addGenid)) {
                    echo " id=\"_" . $addGenid . "\"";
                }

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }

                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onclick)) {
                    echo " onclick=\"" . $onclick . "\"";
                }

                echo ">" . $elementRow["value"];
                echo "</span>";

                if (!empty($link)) {
                    echo "</a>";
                }
            }
            if ($elementRow["type"] == "generic_textarea") {
                echo "<p class=\"" .
                    $class .
                    "\"    style=\"" .
                    $style .
                    "\">" .
                    $elementRow["value"] .
                    "</p>";
            }
            if ($elementRow["type"] == "generic_p") {
                $textarea = $elementRow["value"];

                $newarr = explode("\n", $textarea);

                foreach ($newarr as $str) {
                    echo "<p class=\"" .
                        $class .
                        "\"  style=\"" .
                        $style .
                        "\">" .
                        $str .
                        "</p>";
                }
            }
            if ($elementRow["type"] == "generic_img") {
                //root folder açıkken dil değişince hta dosyasının yeniden yönlendirmesi sebebiyle beta/beta/img/ klasörünü adres gösterip hata veriyordu
                echo "<img  ";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }
                if (!empty($addGenid)) {
                    echo " id=\"_" . $addGenid . "\"";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onclick)) {
                    echo " onclick=\"" . $onclick . "\"";
                }

                if (!empty($alt)) {
                    echo " alt=\"" . $alt . "\"";
                }

                if ($elementRow["value"] != "") {
                    if ($lazyLoadImg) {
                        echo "data-src=\".." .
                            $GLOBALS["RootFolder"] .
                            "/img/" .
                            $elementRow["value"] .
                            "\" ";
                    } else {
                        echo "src=\".." .
                            $GLOBALS["RootFolder"] .
                            "/img/" .
                            $elementRow["value"] .
                            "\" ";
                        //echo "src=\"../img/".$elementRow["value"]."\" ";
                    }
                }

                echo " />";
            }
            if ($elementRow["type"] == "generic_div") {
                if ($noText && $class == "divBultenText") {
                    //basın bülteni text divi anasayfada çıkmaması için özel parametre ekledim
                    echo "</div>"; //divBülten divin kapanışını yapıp döngüyü bitiriyor
                    break;
                }

                echo "<div";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }
                if (!empty($addGenid)) {
                    echo " id=\"_" . $addGenid . "\"";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onclick)) {
                    echo " onclick=\"" . $onclick . "\"";
                }
                if (!empty($addDataTargetid)) {
                    echo " data-targetid=\"" . $addDataTargetid . "\"";
                }
                if (!empty($addDataFilter)) {
                    echo " data-filter=\"" . $addDataFilter . "\"";
                }

                echo ">";
            }
            if ($elementRow["type"] == "generic_/div") {
                if ($firstDiv) {
                    if (!empty($sira)) {
                        getGenericContent("", $sira, $genericRow["id"], $conn);
                    }
                    echo "</div>"; //bu tercih meselesi. ilk div alındıktan sonra da sirası verilen eleman alınabilir.
                    break;
                } else {
                    echo "</div>";
                }
            }
            if ($elementRow["type"] == "generic_input") {
                echo "<input " .
                    $typeString .
                    "  value=\"" .
                    $elementRow["value"] .
                    "\" ";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }
                if (!empty($addGenid)) {
                    echo " id=\"_" . $addGenid . "\"";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onclick)) {
                    echo " onclick=\"" . $onclick . "\"";
                }
                if (!empty($addDataTargetid)) {
                    echo " data-targetid=\"" . $addDataTargetid . "\"";
                }
                if (!empty($addDataFilter)) {
                    echo " data-filter=\"" . $addDataFilter . "\"";
                }

                echo " />";
            }
            if ($elementRow["type"] == "generic_module") {
                if ($elementRow["value"] == "SliderThumbed") {
                    include "SliderThumbed.php";

                    getSliderThumbedForGeneric($elementRow["id"], $conn);
                }
            }
            if ($elementRow["type"] == "generic_list") {
                $Listsql =
                    "SELECT * FROM lists WHERE id=" . $elementRow["value"];
                $ListResult = mysqli_query($conn, $Listsql);

                if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
                    continue;
                }

                $ListRow = mysqli_fetch_assoc($ListResult);

                $class = "";
                $style = "";
                $onClick = "";
                $innerTag = "";
                $itemTag = "";

                $paramsArr = explode("|", $ListRow["parameter"]);

                for ($i = 0; $i < count($paramsArr); $i++) {
                    if (strpos($paramsArr[$i], "class=") !== false) {
                        $classArr = explode("=", $paramsArr[$i]);
                        $class = $classArr[1];
                    }
                    if (strpos($paramsArr[$i], "style=") !== false) {
                        $styleArr = explode("=", $paramsArr[$i]);
                        $style = $styleArr[1];
                    }
                    if (strpos($paramsArr[$i], "onclick=") !== false) {
                        $onClickArr = explode("=", $paramsArr[$i]);
                        $onClick = $onClickArr[1];
                    }
                    if (strpos($paramsArr[$i], "itemTag=") !== false) {
                        $itemTagArr = explode("=", $paramsArr[$i]);
                        $itemTag = $itemTagArr[1];
                    }
                    if (strpos($paramsArr[$i], "innerTag=") !== false) {
                        $innerTagArr = explode("=", $paramsArr[$i]);
                        $innerTag = $innerTagArr[1];
                    }
                }

                if (!empty($ListRow["tag"])) {
                    echo "<" . $ListRow["tag"];
                }

                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\"";
                }

                if (!empty($ListRow["tag"])) {
                    echo ">";
                }

                if (!empty($innerTag)) {
                    echo "<" . $innerTag . ">";
                }

                printListElements($ListRow["id"], $conn);

                if (!empty($innerTag)) {
                    echo "</" . $innerTag . ">";
                }

                echo "</" . $ListRow["tag"] . ">";
            }

            if ($firstElement) {
                break;
            }
        }
    }
}

function getGenericContentIPTAL($loadParam, $sira, $referenceid, $conn)
{
    $sqlElement =
        "SELECT * FROM tagelements WHERE parentid=" .
        $referenceid .
        " AND langid IN(0," .
        $_SESSION["Langid"] .
        ") ";

    $baseStart = ""; //base start ve end arasındaki tagler yazdırılır, geri kalanı echo'ya dahil edilmez
    $baseEnd = "";

    if (!empty($loadParam)) {
        $paramsArr = explode("|", $loadParam);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "filter:") !== false) {
                $sqlElement =
                    $sqlElement .
                    " AND parameter LIKE '%" .
                    $paramsArr[$i] .
                    "%' ";
            }

            if (strpos($paramsArr[$i], "baseStart:") !== false) {
                $baseArr = explode(":", $paramsArr[$i]);

                $baseStart = $baseArr[1];
            }

            if (strpos($paramsArr[$i], "baseEnd:") !== false) {
                $baseArr = explode(":", $paramsArr[$i]);

                $baseEnd = $baseArr[1];
            }
        }
    }

    if (empty($sira)) {
        $sqlElement = $sqlElement . " ORDER BY sira";
    } else {
        $sqlElement = $sqlElement . " AND sira=" . $sira;
    }

    $elementResult = mysqli_query($conn, $sqlElement);

    if ($elementResult == null || mysqli_num_rows($elementResult) == 0) {
        //echo "*error* Element alınamadı.";
        return;
    }

    $baseStarted = false;
    $baseEnded = false;

    while ($elementRow = mysqli_fetch_assoc($elementResult)) {
        $class = "";
        $style = "";
        $link = "";
        $addid = "";
        $addDataFilter = "";
        $onclick = "";
        $alt = "";

        //eğer baseStart ve end parametresi varsa döngü basestartta verilen baseid gelene kadar döngü devam ettirilecek.
        //baseStart geldikten sonra aradaki diğer elemanların da alınması için baseStarted değişkeni yaratılıyor.
        //hem baseStart dolu hem baseStarted true ise echo, değilse continue yapılacak
        //eğer baseid baseend'e eşitse baseEnded true yapılacak ve gelen tag yazdırılacak, bir sonraki döngüde baseEnded
        //true görülürse döngü break ile bitirilecek
        if ($baseStart != "") {
            if ($baseStart == $elementRow["baseid"]) {
                $baseStarted = true;
            }

            if ($baseStarted == false) {
                continue;
            }

            if ($baseEnded == true) {
                break;
            }

            if ($baseEnd == $elementRow["baseid"]) {
                $baseEnded = true;
            }
        }

        $paramsArr = explode("|", $elementRow["parameter"]);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "class=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $class = $classArr[1];
            }
            if (strpos($paramsArr[$i], "style=") !== false) {
                $styleArr = explode("=", $paramsArr[$i]);
                $style = $styleArr[1];
            }
            if (strpos($paramsArr[$i], "link=") !== false) {
                $linkArr = explode("=", $paramsArr[$i]);
                $link = $linkArr[1];
            }
            if (strpos($paramsArr[$i], "targetTag=") !== false) {
                $targetArr = explode("!", $paramsArr[$i]);

                for ($j = 0; $j < count($targetArr); $j++) {
                    if (strpos($targetArr[$j], "targetTag=") !== false) {
                        $targetTagArr = explode("=", $targetArr[$j]);
                        $targetTag = $targetTagArr[1];

                        if (strpos($link, "?") !== false) {
                            $link = $link . "&";
                        } else {
                            $link = $link . "?";
                        }

                        $link = $link . "targetTag=" . $targetTag;
                    }
                    if (strpos($targetArr[$j], "targetClass=") !== false) {
                        $targetClassArr = explode("=", $targetArr[$j]);
                        $targetClass = $targetClassArr[1];

                        $link = $link . "!targetClass=" . $targetClass;
                    }
                    if (strpos($targetArr[$j], "targetid") !== false) {
                        //$link = $link. "!targetid=". $genericRow["targetid"];
                    }
                    if (strpos($targetArr[$j], "selfid") !== false) {
                        //$link = $link. "!selfid=". $genericRow["id"];
                    }
                }
            }

            if (strpos($paramsArr[$i], "addid=") !== false) {
                $addidArr = explode("=", $paramsArr[$i]);
                if ($addidArr[1] == "") {
                    $addid = "_" . $elementRow["parentid"];
                } else {
                    $addid = "_" . $addidArr[1];
                }
            }
            if (strpos($paramsArr[$i], "imgsrc=") !== false) {
                $srcArr = explode("=", $paramsArr[$i]);
                $imgsrc = $srcArr[1];
                //$imgsrc = str_replace("../img/","..".$GLOBALS["RootFolder"]."/img/" , $imgsrc ); img ile başlayacak, başta "/" olmayacak
            }
            if (strpos($paramsArr[$i], "addDataFilter=") !== false) {
                $addDataFilter = str_replace(
                    "addDataFilter=",
                    "",
                    $paramsArr[$i]
                );
            }
            if (strpos($paramsArr[$i], "onclick=") !== false) {
                $onclick = str_replace("onclick=", "", $paramsArr[$i]);
            }
            if (strpos($paramsArr[$i], "alt text=") !== false) {
                $alt = str_replace("alt text=", "", $paramsArr[$i]);
            }
        }

        if (!empty($targetClass)) {
            $class = $class . " " . $targetClass;
            $targetClass = "";
        }

        //arapça için text alanlar style alanına ekleme
        if ($_SESSION["Langid"] == 3) {
            if (
                $elementRow["type"] == "generic_txt" ||
                $elementRow["type"] == "generic_textbox" ||
                $elementRow["type"] == "generic_h1" ||
                $elementRow["type"] == "generic_span" ||
                $elementRow["type"] == "generic_textarea" ||
                $elementRow["type"] == "generic_p"
            ) {
                $style = $style . "direction: rtl; unicode-bidi: plaintext;";
            }
        }

        if ($elementRow["type"] == "generic_txt") {
            echo "<label class=\"" .
                $class .
                "\"    style=\"" .
                $style .
                "\">" .
                $elementRow["value"] .
                "</label>";
        }
        if ($elementRow["type"] == "generic_h1") {
            echo "<h1 class=\"" .
                $class .
                "\"    style=\"" .
                $style .
                "\">" .
                $elementRow["value"] .
                "</h1>";
        }
        if ($elementRow["type"] == "generic_span") {
            if (!empty($link)) {
                echo "<a href=\"" . $link . "\">";
            }

            echo "<span";

            if (!empty($addid)) {
                echo " id=\"" . $addid . "\"";
            }

            echo " class=\"" .
                $class .
                "\"    style=\"" .
                $style .
                "\">" .
                $elementRow["value"];

            echo "</span>";

            if (!empty($link)) {
                echo "</a>";
            }
        }
        if ($elementRow["type"] == "generic_textarea") {
            echo "<p class=\"" .
                $class .
                "\"    style=\"" .
                $style .
                "\">" .
                $elementRow["value"] .
                "</p>";
        }
        if ($elementRow["type"] == "generic_p") {
            echo "<p class=\"" .
                $class .
                "\"  style=\"" .
                $style .
                "\">" .
                $elementRow["value"] .
                "</p>";

            /* //word'den kopyala/yapıştır yapıldıysa olduğu gibi göster: (yazı tag ile başlıyorsa)
            if(strpos($elementRow["value"],'<')>=0) {
                echo str_replace("\n"," ", $elementRow["value"]);
            }
            else {

                $textarea = $elementRow["value"];

                $newarr = explode("\n", $textarea);

                foreach ($newarr as $str) {

                    echo "<p class=\"" . $class . "\"  style=\"" . $style . "\">" . $str . "</p>";
                }

            }*/
        }
        if ($elementRow["type"] == "generic_img") {
            echo "<img class=\"" .
                $class .
                "\"   style=\"" .
                $style .
                "\"    src=\".." .
                $GLOBALS["RootFolder"] .
                "/img/" .
                $elementRow["value"] .
                "\" ";
            //echo "<img class=\"".$class."\"   style=\"".$style."\"    src=\"../img/".$elementRow["value"]."\" ";

            if (!empty($addid)) {
                echo " id=\"" . $addid . "\"";
            }

            if (!empty($onclick)) {
                echo " onclick=\"" . $onclick . "\"";
            }

            if (!empty($alt)) {
                echo " alt=\"" . $alt . "\"";
            }

            echo " />";
        }
        if ($elementRow["type"] == "generic_a") {
            echo "<a href=\"" . $elementRow["value"] . "\">";

            if (!empty($imgsrc)) {
                //echo "<img src=\"..".$GLOBALS["RootFolder"]."/img/".$imgsrc."\" />";
                echo "<img src=\"img/" . $imgsrc . "\" />";
            }

            echo "</a>";
        }
        if ($elementRow["type"] == "generic_file") {
            echo "<a href=\"../file/" . $elementRow["value"] . "\">";

            if (!empty($imgsrc)) {
                //echo "<img src=\"..".$GLOBALS["RootFolder"]."/img/".$imgsrc."\" />";
                echo "<img src=\"img/" . $imgsrc . "\" />";
            }

            echo "</a>";
        }
        if ($elementRow["type"] == "generic_div") {
            echo "<div";

            if (!empty($addid)) {
                echo " id=\"" . $addid . "\"";
            }
            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($addDataFilter)) {
                echo " data-filter=\"" . $addDataFilter . "\"";
            }
            if (!empty($onclick)) {
                echo " onclick=\"" . $onclick . "\"";
            }

            echo ">";
        }
        if ($elementRow["type"] == "generic_/div") {
            echo "</div>";
        }
        if ($elementRow["type"] == "generic_input") {
            echo "<input " .
                $typeString .
                "  value=\"" .
                $elementRow["value"] .
                "\" ";

            if (!empty($addid)) {
                echo " id=\"" . $addid . "\"";
            }
            if (!empty($addGenid)) {
                echo " id=\"_" . $addGenid . "\"";
            }
            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onclick)) {
                echo " onclick=\"" . $onclick . "\"";
            }
            if (!empty($addDataTargetid)) {
                echo " data-targetid=\"" . $addDataTargetid . "\"";
            }
            if (!empty($addDataFilter)) {
                echo " data-filter=\"" . $addDataFilter . "\"";
            }

            echo " />";
        }
        if ($elementRow["type"] == "generic_module") {
            if ($elementRow["value"] == "SliderThumbed") {
                include "SliderThumbed.php";

                getSliderThumbedForGeneric($elementRow["id"], $conn);
            }
        }
        if ($elementRow["type"] == "generic_list") {
            $Listsql = "SELECT * FROM lists WHERE id=" . $elementRow["value"];
            $ListResult = mysqli_query($conn, $Listsql);

            if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
                continue;
            }

            $ListRow = mysqli_fetch_assoc($ListResult);

            $class = "";
            $style = "";
            $onClick = "";
            $innerTag = "";
            $itemTag = "";

            $paramsArr = explode("|", $ListRow["parameter"]);

            for ($i = 0; $i < count($paramsArr); $i++) {
                if (strpos($paramsArr[$i], "class=") !== false) {
                    $classArr = explode("=", $paramsArr[$i]);
                    $class = $classArr[1];
                }
                if (strpos($paramsArr[$i], "style=") !== false) {
                    $styleArr = explode("=", $paramsArr[$i]);
                    $style = $styleArr[1];
                }
                if (strpos($paramsArr[$i], "onclick=") !== false) {
                    $onClickArr = explode("=", $paramsArr[$i]);
                    $onClick = $onClickArr[1];
                }
                if (strpos($paramsArr[$i], "itemTag=") !== false) {
                    $itemTagArr = explode("=", $paramsArr[$i]);
                    $itemTag = $itemTagArr[1];
                }
                if (strpos($paramsArr[$i], "innerTag=") !== false) {
                    $innerTagArr = explode("=", $paramsArr[$i]);
                    $innerTag = $innerTagArr[1];
                }
            }

            if (!empty($ListRow["tag"])) {
                echo "<" . $ListRow["tag"];
            }

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            if (!empty($ListRow["tag"])) {
                echo ">";
            }

            if (!empty($innerTag)) {
                echo "<" . $innerTag . ">";
            }

            printListElements($ListRow["id"], $conn);

            if (!empty($innerTag)) {
                echo "</" . $innerTag . ">";
            }

            echo "</" . $ListRow["tag"] . ">";
        }
    }
}

function getSubpage($subpageid, $conn)
{
    $sql =
        "SELECT * FROM subpagetags WHERE langid=" .
        $_SESSION["Langid"] .
        " AND parentid=0 AND subpageid=" .
        $subpageid;
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        $addid = "";
        $class = "";
        $style = "";
        $onClick = "";
        $type = "";
        $placeholder = "";
        $rows = "";
        $value = "";
        $alt = "";
        $blank = "";

        $paramsArr = explode("|", $Row["parameter"]);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "addid=") !== false) {
                $addidArr = explode("=", $paramsArr[$i]);
                $addid = "_" . $addidArr[1];
            }
            if (strpos($paramsArr[$i], "class=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $class = $classArr[1];
            }
            if (strpos($paramsArr[$i], "style=") !== false) {
                $styleArr = explode("=", $paramsArr[$i]);
                $style = $styleArr[1];
            }
            if (strpos($paramsArr[$i], "onclick=") !== false) {
                $onClick = str_replace("onclick=", "", $paramsArr[$i]);
            }
            if (strpos($paramsArr[$i], "innerTag=") !== false) {
                $innerTagArr = explode("=", $paramsArr[$i]);
                $innerTag = $innerTagArr[1];
            }
            if (strpos($paramsArr[$i], "type=") !== false) {
                $typeArr = explode("=", $paramsArr[$i]);
                $type = $typeArr[1];
            }
            if (strpos($paramsArr[$i], "placeholder=") !== false) {
                $placeholderArr = explode("=", $paramsArr[$i]);
                $placeholder = $placeholderArr[1];
            }
            if (strpos($paramsArr[$i], "rows=") !== false) {
                $rowsArr = explode("=", $paramsArr[$i]);
                $rows = $rowsArr[1];
            }
            if (strpos($paramsArr[$i], "value=") !== false) {
                $valueArr = explode("=", $paramsArr[$i]);
                $value = $valueArr[1];
            }
            if (strpos($paramsArr[$i], "alt text=") !== false) {
                $altArr = explode("=", $paramsArr[$i]);
                $alt = $altArr[1];
            }
            if (strpos($paramsArr[$i], "_blank") !== false) {
                $blank = "_blank";
            }
        }

        if ($Row["type"] == "1") {
            //normal
            if ($Row["tag"] == "img") {
                echo "<" .
                    $Row["tag"] .
                    " src=\"" .
                    str_replace(
                        "../img/",
                        ".." . $GLOBALS["RootFolder"] . "/img/",
                        $Row["value"]
                    ) .
                    "\" ";
                //echo "<".$Row["tag"]." src=\"".$Row["value"] . "\" ";

                if (!empty($class)) {
                    echo " class=\"" . $class . "\" ";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\" ";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\" ";
                }
                if (!empty($alt)) {
                    echo " alt=\"" . $alt . "\" ";
                }

                echo " />";
            } elseif ($Row["tag"] == "a") {
                //echo "<".$Row["tag"]." src=\"".str_replace("../img/","..".$GLOBALS["RootFolder"]."/img/" , $Row["value"] ). "\" ";
                echo "<" . $Row["tag"] . " href=\"" . $Row["value"] . "\" ";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\" ";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\" ";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\" ";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\" ";
                }
                if (!empty($blank)) {
                    echo " target=\"" . $blank . "\" ";
                }

                echo " />";
            } else {
                echo "<" . $Row["tag"];

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\"";
                }
                if (!empty($type)) {
                    echo " type=\"" . $type . "\"";
                }
                if (!empty($placeholder)) {
                    echo " placeholder=\"" . $placeholder . "\"";
                }
                if (!empty($rows)) {
                    echo " rows=\"" . $rows . "\"";
                }
                if (!empty($value)) {
                    echo " value=\"" . $value . "\"";
                }

                echo ">";

                if (!empty($innerTag)) {
                    echo "<" . $innerTag . ">";
                }

                echo $Row["value"];

                if (!empty($innerTag)) {
                    echo "</" . $innerTag . ">";
                }
            }

            getSubpageChild($Row["id"], $conn);

            echo "</" . $Row["tag"] . ">";
        }

        if ($Row["type"] == "2") {
            //generic
            //echo "<div>";
            if (!empty($class)) {
                echo "<div class=\"" . $class . "\">";
            } elseif (!empty($style)) {
                echo "<div style=\"" . $style . "\">";
            } else {
                echo "<div>";
            }
            if (!empty($Row["value"])) {
                echo getGenerics($Row["parameter"], $Row["value"], $conn);
            }
            echo "</div>";
        }
        if ($Row["type"] == "3") {
            //module
            echo getTagGenericGroupList(0, 0, $conn);
        } //burada value alanı alınacak, fonksiyona gönderilecek modül listesinde seçili olan value olacak

        if ($Row["type"] == "4") {
            //list

            echo "<" . $Row["tag"];

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo ">";

            $Listsql = "SELECT * FROM lists WHERE id=" . $Row["value"];
            $ListResult = mysqli_query($conn, $Listsql);

            if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
                continue;
            }

            $ListRow = mysqli_fetch_assoc($ListResult);

            $class = "";
            $style = "";
            $onClick = "";
            $innerTag = "";
            $itemTag = "";

            $paramsArr = explode("|", $ListRow["parameter"]);

            for ($i = 0; $i < count($paramsArr); $i++) {
                if (strpos($paramsArr[$i], "class=") !== false) {
                    $classArr = explode("=", $paramsArr[$i]);
                    $class = $classArr[1];
                }
                if (strpos($paramsArr[$i], "style=") !== false) {
                    $styleArr = explode("=", $paramsArr[$i]);
                    $style = $styleArr[1];
                }
                if (strpos($paramsArr[$i], "onclick=") !== false) {
                    $onClickArr = explode("=", $paramsArr[$i]);
                    $onClick = $onClickArr[1];
                }
                if (strpos($paramsArr[$i], "itemTag=") !== false) {
                    $itemTagArr = explode("=", $paramsArr[$i]);
                    $itemTag = $itemTagArr[1];
                }
                if (strpos($paramsArr[$i], "innerTag=") !== false) {
                    $innerTagArr = explode("=", $paramsArr[$i]);
                    $innerTag = $innerTagArr[1];
                }
            }

            echo "<" . $ListRow["tag"];

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo ">";

            if (!empty($innerTag)) {
                echo "<" . $innerTag . ">";
            }

            printListElements($ListRow["id"], $conn);

            if (!empty($innerTag)) {
                echo "</" . $innerTag . ">";
            }

            echo "</" . $ListRow["tag"] . ">";

            echo "</" . $Row["tag"] . ">";
        }
    }
}

function getSubpageChild($parentid, $conn)
{
    $sqlChild =
        "SELECT * FROM subpagetags WHERE langid=" .
        $_SESSION["Langid"] .
        " AND parentid=" .
        $parentid;
    $Result = mysqli_query($conn, $sqlChild);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($childRow = mysqli_fetch_assoc($Result)) {
        $addid = "";
        $class = "";
        $style = "";
        $onClick = "";
        $innerTag = "";
        $type = "";
        $placeholder = "";
        $rows = "";
        $value = "";
        $alt = "";
        $blank = "";

        $paramsArr = explode("|", $childRow["parameter"]);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "addid=") !== false) {
                $addidArr = explode("=", $paramsArr[$i]);
                $addid = "_" . $addidArr[1];
            }
            if (strpos($paramsArr[$i], "class=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $class = $classArr[1];
            }
            if (strpos($paramsArr[$i], "style=") !== false) {
                $styleArr = explode("=", $paramsArr[$i]);
                $style = $styleArr[1];
            }
            if (strpos($paramsArr[$i], "onclick=") !== false) {
                $onClick = str_replace("onclick=", "", $paramsArr[$i]);
            }
            if (strpos($paramsArr[$i], "innerTag=") !== false) {
                $innerTagArr = explode("=", $paramsArr[$i]);
                $innerTag = $innerTagArr[1];
            }
            if (strpos($paramsArr[$i], "type=") !== false) {
                $typeArr = explode("=", $paramsArr[$i]);
                $type = $typeArr[1];
            }
            if (strpos($paramsArr[$i], "placeholder=") !== false) {
                $placeholderArr = explode("=", $paramsArr[$i]);
                $placeholder = $placeholderArr[1];
            }
            if (strpos($paramsArr[$i], "rows=") !== false) {
                $rowsArr = explode("=", $paramsArr[$i]);
                $rows = $rowsArr[1];
            }
            if (strpos($paramsArr[$i], "value=") !== false) {
                $valueArr = explode("=", $paramsArr[$i]);
                $value = $valueArr[1];
            }
            if (strpos($paramsArr[$i], "href=") !== false) {
                $href = str_replace("href=", "", $paramsArr[$i]);
            }
            if (strpos($paramsArr[$i], "alt text=") !== false) {
                $altArr = explode("=", $paramsArr[$i]);
                $alt = $altArr[1];
            }
            if (strpos($paramsArr[$i], "_blank") !== false) {
                $blank = "_blank";
            }
        }

        if ($childRow["type"] == "1") {
            //normal
            if ($childRow["tag"] == "img") {
                echo "<" .
                    $childRow["tag"] .
                    " src=\"" .
                    str_replace(
                        "../img/",
                        ".." . $GLOBALS["RootFolder"] . "/img/",
                        $childRow["value"]
                    ) .
                    "\" ";
                //echo "<".$childRow["tag"]." src=\"".$childRow["value"] . "\" ";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\" ";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\" ";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\" ";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\" ";
                }
                if (!empty($alt)) {
                    echo " alt=\"" . $alt . "\" ";
                }

                echo " />";
            } elseif ($childRow["tag"] == "a") {
                //echo "<".$Row["tag"]." src=\"".str_replace("../img/","..".$GLOBALS["RootFolder"]."/img/" , $Row["value"] ). "\" ";
                echo "<" .
                    $childRow["tag"] .
                    " href=\"" .
                    $childRow["value"] .
                    "\" ";

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\" ";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\" ";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\" ";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\" ";
                }
                if (!empty($blank)) {
                    echo " target=\"" . $blank . "\" ";
                }

                echo " />";
            } else {
                echo "<" . $childRow["tag"];

                if (!empty($addid)) {
                    echo " id=\"" . $addid . "\"";
                }
                if (!empty($class)) {
                    echo " class=\"" . $class . "\"";
                }
                if (!empty($style)) {
                    echo " style=\"" . $style . "\"";
                }
                if (!empty($onClick)) {
                    echo " onclick=\"" . $onClick . "\"";
                }
                if (!empty($type)) {
                    echo " type=\"" . $type . "\"";
                }
                if (!empty($placeholder)) {
                    echo " placeholder=\"" . $placeholder . "\"";
                }
                if (!empty($rows)) {
                    echo " rows=\"" . $rows . "\"";
                }
                if (!empty($value)) {
                    echo " value=\"" . $value . "\"";
                }
                if (!empty($href)) {
                    echo " href=\"" . $href . "\"";
                }

                echo ">";

                if (!empty($innerTag)) {
                    echo "<" . $innerTag . ">";
                }

                echo $childRow["value"];

                if (!empty($innerTag)) {
                    echo "</" . $innerTag . ">";
                }
            }

            getSubpageChild($childRow["id"], $conn);

            echo "</" . $childRow["tag"] . ">";
        }

        if ($childRow["type"] == "2") {
            //generic
            //echo "<div>";
            if (!empty($class)) {
                echo "<div class=\"" . $class . "\">";
            } elseif (!empty($style)) {
                echo "<div style=\"" . $style . "\">";
            } else {
                echo "<div>";
            }
            if (!empty($childRow["value"])) {
                echo getGenerics(
                    $childRow["parameter"],
                    $childRow["value"],
                    $conn
                );
            }
            echo "</div>";
        }
        if ($childRow["type"] == "3") {
            //module
            echo getTagGenericGroupList(0, 0, $conn);
        } //burada value alanı alınacak, fonksiyona gönderilecek modül listesinde seçili olan value olacak

        if ($childRow["type"] == "4") {
            //list

            echo "<" . $childRow["tag"];

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo ">";

            $Listsql = "SELECT * FROM lists WHERE id=" . $childRow["value"];
            $ListResult = mysqli_query($conn, $Listsql);

            if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
                continue;
            }

            $ListRow = mysqli_fetch_assoc($ListResult);

            $class = "";
            $style = "";
            $onClick = "";
            $innerTag = "";
            $itemTag = "";

            $paramsArr = explode("|", $ListRow["parameter"]);

            for ($i = 0; $i < count($paramsArr); $i++) {
                if (strpos($paramsArr[$i], "class=") !== false) {
                    $classArr = explode("=", $paramsArr[$i]);
                    $class = $classArr[1];
                }
                if (strpos($paramsArr[$i], "style=") !== false) {
                    $styleArr = explode("=", $paramsArr[$i]);
                    $style = $styleArr[1];
                }
                if (strpos($paramsArr[$i], "onclick=") !== false) {
                    $onClickArr = explode("=", $paramsArr[$i]);
                    $onClick = $onClickArr[1];
                }
                if (strpos($paramsArr[$i], "itemTag=") !== false) {
                    $itemTagArr = explode("=", $paramsArr[$i]);
                    $itemTag = $itemTagArr[1];
                }
                if (strpos($paramsArr[$i], "innerTag=") !== false) {
                    $innerTagArr = explode("=", $paramsArr[$i]);
                    $innerTag = $innerTagArr[1];
                }
            }

            echo "<" . $ListRow["tag"];

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo ">";

            if (!empty($innerTag)) {
                echo "<" . $innerTag . ">";
            }

            printListElements($ListRow["id"], $conn);

            if (!empty($innerTag)) {
                echo "</" . $innerTag . ">";
            }

            echo "</" . $ListRow["tag"] . ">";

            echo "</" . $childRow["tag"] . ">";
        }
    }
}

function getList($listid, $conn)
{
    if (!empty($class)) {
        echo " class=\"" . $class . "\"";
    }
    if (!empty($style)) {
        echo " style=\"" . $style . "\"";
    }
    if (!empty($onClick)) {
        echo " onclick=\"" . $onClick . "\"";
    }

    $Listsql = "SELECT * FROM lists WHERE id=" . $listid;
    $ListResult = mysqli_query($conn, $Listsql);

    if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
        return;
    }

    $ListRow = mysqli_fetch_assoc($ListResult);

    $class = "";
    $style = "";
    $onClick = "";
    $innerTag = "";
    $itemTag = "";

    $paramsArr = explode("|", $ListRow["parameter"]);

    for ($i = 0; $i < count($paramsArr); $i++) {
        if (strpos($paramsArr[$i], "class=") !== false) {
            $classArr = explode("=", $paramsArr[$i]);
            $class = $classArr[1];
        }
        if (strpos($paramsArr[$i], "style=") !== false) {
            $styleArr = explode("=", $paramsArr[$i]);
            $style = $styleArr[1];
        }
        if (strpos($paramsArr[$i], "onclick=") !== false) {
            $onClickArr = explode("=", $paramsArr[$i]);
            $onClick = $onClickArr[1];
        }
        if (strpos($paramsArr[$i], "itemTag=") !== false) {
            $itemTagArr = explode("=", $paramsArr[$i]);
            $itemTag = $itemTagArr[1];
        }
        if (strpos($paramsArr[$i], "innerTag=") !== false) {
            $innerTagArr = explode("=", $paramsArr[$i]);
            $innerTag = $innerTagArr[1];
        }
    }

    if (!empty($ListRow["tag"])) {
        echo "<" . $ListRow["tag"];

        if (!empty($class)) {
            echo " class=\"" . $class . "\"";
        }
        if (!empty($style)) {
            echo " style=\"" . $style . "\"";
        }
        if (!empty($onClick)) {
            echo " onclick=\"" . $onClick . "\"";
        }

        echo ">";
    }

    if (!empty($innerTag)) {
        echo "<" . $innerTag . ">";
    }

    printListElements($ListRow["id"], $conn);

    if (!empty($innerTag)) {
        echo "</" . $innerTag . ">";
    }

    if (!empty($ListRow["tag"])) {
        echo "</" . $ListRow["tag"] . ">";
    }
}

function printListElements($listid, $conn)
{
    $Listsql =
        "SELECT * FROM tagelements WHERE type='listitem' AND parentid=" .
        $listid .
        " AND langid IN(0," .
        $_SESSION["Langid"] .
        ")";
    $ListResult = mysqli_query($conn, $Listsql);

    if ($ListResult == null || mysqli_num_rows($ListResult) == 0) {
        return;
    }

    while ($ListRow = mysqli_fetch_assoc($ListResult)) {
        $class = "";
        $itemClass = "";
        $style = "";
        $listTag = "";
        $innerTag = "";
        $itemTag = "";
        $extraTag = "";
        $src = "";
        $onClick = "";
        $href = "";
        $nofollow = "";

        $paramsArr = explode("|", $ListRow["parameter"]);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "class=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $class = $classArr[1];
            }
            if (strpos($paramsArr[$i], "itemClass=") !== false) {
                $classArr = explode("=", $paramsArr[$i]);
                $itemClass = $classArr[1];
            }
            if (strpos($paramsArr[$i], "style=") !== false) {
                $styleArr = explode("=", $paramsArr[$i]);
                $style = $styleArr[1];
            }
            if (strpos($paramsArr[$i], "listTag=") !== false) {
                $tagArr = explode("=", $paramsArr[$i]);
                $listTag = $tagArr[1];
            }
            if (strpos($paramsArr[$i], "innerTag=") !== false) {
                $tagArr = explode("=", $paramsArr[$i]);
                $innerTag = $tagArr[1];
            }
            if (strpos($paramsArr[$i], "itemTag=") !== false) {
                $tagArr = explode("=", $paramsArr[$i]);
                $itemTag = $tagArr[1];
            }
            if (strpos($paramsArr[$i], "extraTag=") !== false) {
                $tagArr = explode("=", $paramsArr[$i]);
                $extraTag = $tagArr[1];
            }
            if (strpos($paramsArr[$i], "src=") !== false) {
                $tagArr = explode("=", $paramsArr[$i]);
                $src = $tagArr[1];
                //$src = str_replace("../img/","..".$GLOBALS["RootFolder"]."/img/" , $src );
            }
            if (strpos($paramsArr[$i], "onclick=") !== false) {
                $onClickArr = explode("=", $paramsArr[$i]);
                $onClick = $onClickArr[1];
            }
            if (strpos($paramsArr[$i], "href=") !== false) {
                $href = str_replace("href=", "", $paramsArr[$i]);
            }
            if (strpos($paramsArr[$i], "nofollow") !== false) {
                $nofollow = "nofollow";
            }
        }

        if (!empty($listTag)) {
            echo "<" . $listTag;

            if (!empty($class)) {
                echo " class=\"" . $class . "\"";
            }
            if (!empty($style)) {
                echo " style=\"" . $style . "\"";
            }
            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo ">";
        }

        if (!empty($innerTag)) {
            echo "<" . $innerTag;

            if (!empty($href)) {
                echo " href=\"" . $href . "\"";
            }
            if (!empty($nofollow)) {
                echo " rel=\"nofollow\"";
            }

            echo ">";
        }

        if ($itemTag == "img") {
            echo "<img src=\"" .
                str_replace(
                    "../img/",
                    ".." . $GLOBALS["RootFolder"] . "/img/",
                    $src
                ) .
                "\" ";

            if (!empty($onClick)) {
                echo " onclick=\"" . $onClick . "\"";
            }

            echo "/>";
        } else {
            if (!empty($itemTag)) {
                echo "<" . $itemTag;
            }

            if (!empty($href)) {
                echo " href=" . $href;
            }

            if (!empty($itemClass)) {
                echo " class=" . $itemClass;
            }

            if (!empty($itemTag)) {
                echo ">";
            }

            echo $ListRow["value"];

            if (!empty($itemTag)) {
                echo "</" . $itemTag . ">";
            }
        }

        if (!empty($extraTag)) {
            echo "<" . $extraTag;

            echo ">";
        }

        if (!empty($innerTag)) {
            echo "</" . $innerTag . ">";
        }

        if (!empty($extraTag)) {
            echo "</" . $extraTag . ">";
        }

        if (!empty($listTag)) {
            echo "</" . $listTag . ">";
        }
    }
}
