<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) 
{
    ErrorMessage::show("No ID passed into page");
}

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();
?>
<div class="watchContainer">

    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-angle-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>

    </div>

    <video controls autoplay>
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4"'>
    </video>
</div>
<script>
    /*runs the initVideo function in script.js, parses 2 variables which 
    is videoId and user that logged in*/
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>