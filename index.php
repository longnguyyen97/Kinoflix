<?php
require_once("includes/header.php");
$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createPreviewVideo(null);
?>