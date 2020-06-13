<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]))
{
    $query = $conn->prepare("UPDATE videoProgress SET finished=1, progress=0 
                             WHERE username=:username AND videoId=:videoId"); //set the finish column to 0 in table
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->execute();


    
}
else 
{
    echo "no video id or username passed into file";
}
?>