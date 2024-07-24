<?php

//if (session_id() === "") { session_start(); }
if (
    (function_exists("session_status") &&
        session_status() !== PHP_SESSION_ACTIVE) ||
    !session_id()
) {
    session_start();
}

if (!isset($_SESSION["CREATED"])) {
    $_SESSION["CREATED"] = time();
} elseif (time() - $_SESSION["CREATED"] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true); // change session ID for the current session and invalidate old session ID
    $_SESSION["CREATED"] = time(); // update creation time
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fooddb";

//sunucuda halihazırda site varsa beta klasörü altına ekleme yapılıyor
//$GLOBALS["RootFolder"] = "/beta";
$GLOBALS["RootFolder"] = "";

if (!isset($_SESSION["PasteWithStyle"])) {
    $_SESSION["PasteWithStyle"] = false;
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($conn, "SET NAMES 'utf8'");
