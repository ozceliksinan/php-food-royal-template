<?php
session_start();
include "Genel.php";

$callFunction = "";

if (isset($_POST["call"])) {
    $callFunction = $_POST["call"];
}

if ($callFunction == "getFirstImgUrl") {
    getFirstImgUrl($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "loadSearchids") {
    loadSearchids($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "sendIletisimForm") {
    sendIletisimForm($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "loadBlogCount") {
    loadBlogCount($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "aramaSorguKaydet") {
    aramaSorguKaydet();
    mysqli_close($conn);
    return;
}

if ($callFunction == "aramaSorguGetir") {
    aramaSorguGetir();
    mysqli_close($conn);
    return;
}

if ($callFunction == "aramaSonucYukle") {
    aramaSonucYukle($conn);
    mysqli_close($conn);
    return;
}

if ($callFunction == "aramaSonucSayiYukle") {
    aramaSonucSayiYukle($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "loadImgSrcs") {
    loadImgSrcs($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getGenericid") {
    getGenericid($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getGenericUrlName") {
    getGenericUrlName($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "setGenericMeta") {
    setGenericMeta($conn);
    mysqli_close($conn);
    return;
}
if ($callFunction == "getResponse") {
    echo getResponse($_POST["code"], $conn);
    mysqli_close($conn);
    return;
}

function getFirstImgUrl($conn)
{
    $portfolyoid = $_POST["portid"];

    $sqlTarget = "SELECT targetid FROM generic WHERE id=" . $portfolyoid;
    $ResultTarget = mysqli_query($conn, $sqlTarget);

    if ($ResultTarget == null || mysqli_num_rows($ResultTarget) == 0) {
        return;
    }

    $RowTarget = mysqli_fetch_assoc($ResultTarget);

    $targetid = $RowTarget["targetid"];

    $sql =
        "SELECT value FROM tagelements WHERE type='SliderThumbed' AND parentid=
		   (SELECT id FROM tagelements WHERE type='generic_module' AND value='SliderThumbed' AND parentid=" .
        $targetid .
        " LIMIT 1)
		   ORDER BY sira LIMIT 1";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    $Row = mysqli_fetch_assoc($Result);

    echo "img/" . $Row["value"];
}

function loadSearchids($conn)
{
    $query = $_POST["query"];

    $sql =
        "SELECT generic.id,generic.genericgroupid

				  FROM tagelements
				  JOIN generic g1 ON generic.id=tagelements.parentid AND genericgroupid IN (5,9)

				  WHERE type='generic_p' AND value LIKE '%" .
        $query .
        "%'";

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo ",";
        echo $Row["id"];
        echo ".";
        echo $Row["genericgroupid"];
    }
}

function sendIletisimForm($conn)
{
    if (!empty($_POST["isim"])) {
        $isim = $_POST["isim"];

        if (!preg_match("/^[a-zA-ZÇŞĞÜÖİçşğüöı ]*$/", $isim)) {
            echo getResponse("isimKontrol", $conn);
            return;
        }
    } else {
        echo getResponse("isimEksik", $conn);
        return;
    }

    if (!empty($_POST["mail"])) {
        $mail = $_POST["mail"];

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo getResponse("mailKontrol", $conn);
            return;
        }
    }
    /*else{
		echo getResponse("mailEksik",$conn);
		return;
	}*/

    if (!empty($_POST["konu"])) {
        $konu = $_POST["konu"];
    } else {
        $konu = "";
    }

    if (!empty($_POST["telefon"])) {
        $telefon = $_POST["telefon"];
    } else {
        $telefon = "";
    }

    if (!empty($_POST["mesaj"])) {
        $mesaj = $_POST["mesaj"];
    } else {
        $mesaj = "";
    }

    $isim = str_replace("'", "''", $isim);
    $telefon = str_replace("'", "''", $telefon);
    $konu = str_replace("'", "''", $mail);
    $mesaj = str_replace("'", "''", $mesaj);

    $sql =
        "INSERT INTO iletisimform ( isim, telefon, mail, mesaj) VALUES ('" .
        $isim .
        "', '" .
        $konu .
        "',  '" .
        $telefon .
        "',  '" .
        $mesaj .
        "')";

    if (!mysqli_query($conn, $sql)) {
        echo getResponse("kayitHata", $conn);
        return;
    }

    require "PHPMailerAutoload.php";

    echo sendIletisimMail($isim, $telefon, $mail, $mesaj, $conn); //info adresi

    echo "ok" . getResponse("mesajOK", $conn);
}

function sendIletisimMail($isim, $tel, $email, $message, $conn)
{
    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";

    $mail->isSMTP(); // Set mailer to use SMTP

    $mail->Host = "mail.kurumsaleposta.com"; // Specify main and backup server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = "test@test.com"; // SMTP username
    $mail->Password = "password"; // SMTP password
    //$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
    $mail->setFrom("test@test.com", "Sample Website"); //Set who the message is to be sent from
    //$mail->addReplyTo('labnol@gmail.com', 'First Last');  //Set an alternative reply-to address
    $mail->addAddress("test@test.com", "Sample Info"); // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    $mail->WordWrap = 50; // Set word wrap to 50 characters
    //$mail->addAttachment('../img/logo_darker.png','logo');         // Add attachments
    //$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
    $mail->AddEmbeddedImage("../img/logo.png", "logo");
    $mail->isHTML(true); // Set email format to HTML

    $mail->Subject = "Web İletişim Mesajı";
    $mail->AltBody =
        "Web sitesi üzerinden yeni iletişim mesajı gönderildi, lütfen kontrol ediniz."; //non-html

    $mail->Body =
        '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>İletişim Mesajı</title>
</head>
<body>

    <img  src="cid:logo" style="position:relative; display:block; max-width:40%;  margin:0 auto;"/>

    <h1 style="font-size:125%; text-align:center; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1); color:blue;">İletişim Mesajı</h1>

    <p style="text-align:center;">Web sitesi üzerinden iletişim mesajı alındı, lütfen dönüş yapın.</p>

    <div style="margin-top:10px; padding:10px 0; text-align:center; border-top:1px solid lightgray;border-bottom:1px solid lightgray;">
    <span>İsim: </span><span>' .
        $isim .
        '</span><br />
    <span>Telefon: </span><span>' .
        $tel .
        '</span><br />
    <span>Konu: </span><span>' .
        $email .
        '</span><br /><br />
    <span>Mesaj: </span><p>' .
        $message .
        '</p>
    </div>

</body>
</html>
';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

    if (!$mail->send()) {
        echo getResponse("mailHata", $conn) .
            " Mailer Error: " .
            $mail->ErrorInfo;
        exit();
    }

    //echo "mail gönderildi"; BURAYA RETURN OK EKLEMEK GEREK
}

function getResponse($code, $conn)
{
    $sql =
        "SELECT message FROM response WHERE langid=" .
        $_SESSION["Langid"] .
        " AND code='" .
        $code .
        "'";
    $ResultTarget = mysqli_query($conn, $sql);

    if ($ResultTarget == null || mysqli_num_rows($ResultTarget) == 0) {
        return "error";
    }

    $RowTarget = mysqli_fetch_assoc($ResultTarget);

    return $RowTarget["message"];
}

function loadBlogCount($conn)
{
    $masterid = $_POST["query"];

    $sql = "SELECT count(0) sayi FROM generic where genericgroupid = 9";

    if (!empty($masterid)) {
        $sql = $sql . " AND masterid=" . $masterid;
    }

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    $Row = mysqli_fetch_assoc($Result);
    echo $Row["sayi"];
}

function aramaSorguKaydet()
{
    $_SESSION["sorgu"] = $_POST["sorgu"];

    echo "ok";
}

function aramaSorguGetir()
{
    echo $_SESSION["sorgu"];
}

function aramaSonucYukle($conn)
{
    $indexNo = 0;

    $searchArr = explode(" ", $_SESSION["sorgu"]);

    $sql = "
        SELECT tagelements.parentid, tagelements.value, gen2.id menuDivid, tage1.parameter

		FROM tagelements
		JOIN generic gen1 ON gen1.id=tagelements.parentid AND gen1.genericgroupid IN (6,9)
		LEFT JOIN generic gen2 ON tagelements.parentid = gen2.targetid
		LEFT JOIN tagelements tage1 ON tagelements.parentid=tage1.parentid AND tagelements.sira-1 = tage1.sira

        WHERE tagelements.type IN ('generic_p','generic_h1') AND ";

    for ($i = 0; $i < count($searchArr); $i++) {
        $sql = $sql . " tagelements.value LIKE '%" . $searchArr[$i] . "%' OR";
    }

    $sql = rtrim($sql, "OR");

    $sql = $sql . " ORDER BY parentid";

    if (!empty($_POST["loadParam"])) {
        $paramsArr = explode("!", $_POST["loadParam"]);

        for ($i = 0; $i < count($paramsArr); $i++) {
            if (strpos($paramsArr[$i], "offset:") !== false) {
                $offsetArr = explode(":", $paramsArr[$i]);
                $sql = $sql . " OFFSET " . $offsetArr[1] . " ";
                $indexNo = intval($offsetArr[1]);
            }
            if (strpos($paramsArr[$i], "limit:") !== false) {
                $limitArr = explode(":", $paramsArr[$i]);
                $sql = $sql . " LIMIT " . $limitArr[1] . " ";
            }
        }
    }

    $Result = mysqli_query($conn, $sql);

    echo "<div class=\"divSonuc\">";

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "<span>Sonuç bulunamadı.</span>";
        echo "</div>";
        return;
    }

    echo '<span id="spSonuc"></span> <span> sonuç bulundu.</span>';

    echo "</div>";

    $parentid = "0";
    $resultArr = [];

    while ($Row = mysqli_fetch_assoc($Result)) {
        if ($parentid != $Row["parentid"]) {
            $parentid = $Row["parentid"];
            $resultArr = [];
            $menuDivid = $Row["menuDivid"];
            $dataFilter = "";

            $filterParams = explode("|", $Row["parameter"]);

            for ($i = 0; $i < count($filterParams); $i++) {
                if (strpos($filterParams[$i], "addDataFilter=") !== false) {
                    $filterArr = explode("=", $filterParams[$i]);
                    $dataFilter = $filterArr[1];
                }
            }

            echo "</div>";

            $sqlHeader =
                "SELECT value,genericgroupid FROM tagelements
                          JOIN generic ON generic.id=tagelements.parentid
                          WHERE parentid =" .
                $parentid .
                " AND type='generic_h1'";

            $ResultHeader = mysqli_query($conn, $sqlHeader);

            if ($ResultHeader == null || mysqli_num_rows($ResultHeader) == 0) {
                echo "Başlık alınamadı!";
                return;
            }

            $RowHeader = mysqli_fetch_assoc($ResultHeader);

            if ($menuDivid == "") {
                $menuDivid = "null";
            }

            if ($dataFilter == "") {
                $dataFilter = "null";
            }

            echo "<div class=\"divResult\" onclick=\"sonucYonlendir(" .
                $RowHeader["genericgroupid"] .
                "," .
                $parentid .
                "," .
                $menuDivid .
                "," .
                $dataFilter .
                ");\">";

            if ($RowHeader["genericgroupid"] == "6") {
                echo "<h1>Ekibimiz: " . $RowHeader["value"] . "</h1>";
            }

            if ($RowHeader["genericgroupid"] == "9") {
                echo "<h1>Blog: " . $RowHeader["value"] . "</h1>";
            }
        }

        for ($i = 0; $i < count($searchArr); $i++) {
            if (strpos($Row["value"], $searchArr[$i]) !== false) {
                if (!in_array($searchArr[$i], $resultArr)) {
                    echo "<span>" . $searchArr[$i] . "</span>";
                    $resultArr[] = $searchArr[$i];
                }
            }
        }
    }

    echo "</div>"; //!!!!!!!!!!!!!!!
}

function aramaSonucSayiYukle($conn)
{
    $searchArr = explode(" ", $_SESSION["sorgu"]);

    $sql = "
        SELECT count(0) sayi

		FROM tagelements
		JOIN generic gen1 ON gen1.id=tagelements.parentid AND gen1.genericgroupid IN (6,9)
		left join generic gen2 ON tagelements.parentid = gen2.targetid
		left join tagelements tage1 ON tagelements.parentid=tage1.parentid AND tagelements.sira-1 = tage1.sira

        WHERE tagelements.type IN ('generic_p','generic_h1') AND ";

    for ($i = 0; $i < count($searchArr); $i++) {
        $sql = $sql . " tagelements.value LIKE '%" . $searchArr[$i] . "%' OR";
    }

    $sql = rtrim($sql, "OR");

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    $Row = mysqli_fetch_assoc($Result);
    echo $Row["sayi"];
}

function loadImgSrcs($conn)
{
    $sql = "SELECT parameter FROM tagelements
            WHERE parentid=2 AND type='listitem' ";

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo ",";
        echo $Row["parameter"];
    }
}

function getGenericid($conn)
{
    $urlName = $_POST["urlName"];

    $sql = "SELECT id FROM generic where urlname ='" . $urlName . "'";

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "yok";
        return;
    }

    $Row = mysqli_fetch_assoc($Result);
    echo $Row["id"];
}

function getGenericUrlName($conn)
{
    $genericid = $_POST["genericid"];

    $sql = "SELECT urlname FROM generic where id =" . $genericid;

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        echo "yok";
        return;
    }

    $Row = mysqli_fetch_assoc($Result);
    echo $Row["urlname"];
}

function setGenericMeta($conn)
{
    $sql =
        "SELECT *
	        FROM generic
            WHERE id=" . $_POST["id"];

    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    $Row = mysqli_fetch_assoc($Result);

    echo $Row["title"];
    echo "|";
    echo $Row["description"];
}
