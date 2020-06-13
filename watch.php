<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();
?>