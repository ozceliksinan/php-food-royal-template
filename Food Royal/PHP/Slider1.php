<?php
include "Genel.php";

$Sliderid = $_POST["Sliderid"];

$sql =
    "SELECT value FROM tagelements WHERE type='Slider1' AND  parentid=" .
    $Sliderid .
    " ORDER BY sira";
$Result = mysqli_query($conn, $sql);

if ($Result == null || mysqli_num_rows($Result) == 0) {
    return;
}

while ($Row = mysqli_fetch_assoc($Result)) {
    echo ",.." . $GLOBALS["RootFolder"] . "/img/" . $Row["value"];
}
?>