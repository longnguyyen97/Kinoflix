<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    exit("No ID passed into page");
}
$entityId = $_GET["id"];
$entity = new Entity($conn, $entityId);

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createPreviewVideo($entity);
?>