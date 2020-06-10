<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");

$userLoggedIn = $_SESSION['userLoggedIn'];
$preview = new PreviewProvider($conn, $userLoggedIn);

echo $preview->createPreviewVideo();
?>