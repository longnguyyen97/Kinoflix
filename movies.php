<?php
require_once("includes/header.php");
$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createMoviePreviewVideo();

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showTVShowCategories();
?>