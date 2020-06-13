<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]))
{
    $query = $conn->prepare("SELECT progress FROM videoProgress 
                             WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    
    $query->execute();

    echo $query->fetchColumn(); //get the valie from column progress in videoProcess table and return it as data
}
else 
{
    echo "no video id or username passed into file";
}
?>