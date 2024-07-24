<?php

include "Genel.php";

$GLOBALS["imgCount"] = 8;

$callFunction = "";

if (isset($_POST["call"])) {
    $callFunction = $_POST["call"];
}

if ($callFunction == "getSliderThumbedArray") {
    getSliderThumbedArray($conn);
    mysqli_close($conn);
    return;
}

function getSliderThumbedForGeneric($sliderid)
{
    echo "<div id=\"_" .
        $sliderid .
        "_divSliderThumbed\" class=\"divSliderThumbed\">";
    echo "<div id=\"_" .
        $sliderid .
        "_divSlthBigImgs\" class=\"divSliderBigImg\">";
    echo "<img  />";
    echo "<img  />";
    echo "</div>"; //big img sonu

    echo "<div class=\"divSliderThumbAlt\">";

    echo "<div class=\"divSliderThumbContainer\">";
    echo "<div id=\"_" .
        $sliderid .
        "_divSliderThumbs\" class=\"divSliderThumbs\">";

    /*for($i=0; $i<$GLOBALS["imgCount"]; $i++)
					{
	echo				"<img onclick=\"LoadImg(".$sliderid.",this);\"></img>";
					}
					*/

    echo "</div>"; //thumbs sonu

    echo "<span class=\"arrow_carrot-left span1\" onclick=\"prevImg(" .
        $sliderid .
        ");\"></span>";
    echo "<span class=\"arrow_carrot-right span2\" onclick=\"nextImg(" .
        $sliderid .
        ");\"></span>";

    echo "</div>"; //thumbs container sonu

    echo "</div>"; //thumb alt sonu
    echo "</div>"; //ana div
}

function getSliderThumbedArray($conn)
{
    $Sliderid = $_POST["Sliderid"];

    $sql =
        "SELECT value FROM tagelements WHERE type='SliderThumbed' AND parentid=" .
        $Sliderid .
        " ORDER BY sira";
    $Result = mysqli_query($conn, $sql);

    if ($Result == null || mysqli_num_rows($Result) == 0) {
        return;
    }

    while ($Row = mysqli_fetch_assoc($Result)) {
        echo ",.." . $GLOBALS["RootFolder"] . "/img/" . $Row["value"];
    }
}
?>