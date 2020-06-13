<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) 
{
    ErrorMessage::show("No ID passed into page");
}

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();
$upNextVideo = VideoProvider::getUpNext($conn, $video);
?>
<div class="watchContainer">

    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-angle-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext" style="display:none;">
        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>

        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>
            <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId();?>)">
                <i class="fas fa-play"></i>Play
            </button>
        </div>
    </div>

    <video controls autoplay onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4"'>
    </video>
</div>
<script>
    /*runs the initVideo function in script.js, parses 2 variables which 
    is videoId and user that logged in*/
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>