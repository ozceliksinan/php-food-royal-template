<?php

if (
    (function_exists("session_status") &&
        session_status() !== PHP_SESSION_ACTIVE) ||
    !session_id()
) {
    session_start();
}

/*if (session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}*/

if (!isset($_SESSION["Langid"])) {
    $_SESSION["Langid"] = 1;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fooddb";

//sunucuda halihazırda site varsa beta klasörü altına ekleme yapılıyor
//$GLOBALS["RootFolder"] = "/beta";
$GLOBALS["RootFolder"] = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($conn, "SET NAMES 'utf8'");