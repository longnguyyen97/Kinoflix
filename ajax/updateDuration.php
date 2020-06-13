<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"]))
{
    /*update the progress of the video with NOW() fuction from mysql which it 
    will get the time from event.target.currentTime from script.js*/
    $query = $conn->prepare("UPDATE videoProgress SET progress=:progress,
                             dateModified=NOW() WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":progress", $_POST["progress"]); //update progress and insert it into database
    $query->execute();


    
}
else 
{
    echo "no video id or username passed into file";
}
?>