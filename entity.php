<?php
require_once("includes/header.php");
if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}
$entityId = $_GET["id"];
$entity = new Entity($conn, $entityId);

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($conn, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainer = new CategoryContainers($conn, $userLoggedIn);
echo $categoryContainer->showCategory($entity->getCategoryId(), "You might also like");
?>