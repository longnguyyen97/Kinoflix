<?php
class PreviewProvider
{
    private $conn, $username;

    public function __construct($conn, $username)
    {
        $this->conn= $conn;
        $this->username= $username;
    }
    public function createPreviewVideo($entity)
    {
        if($entity == null)
        {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();
        
        $videoId = VideoProvider::getEntityVideoForUser($this->conn, $id, $this->username);
        $video = new Video($this->conn, $videoId);
        
        //if video is in watching progress, switch button text to Contitnue
        $isInProgress = $video->isInProgress($this->username);
        $playButtonText = $isInProgress ? "Continue watching" : "Play";

        //preview video show current season and episode of the TV show you're watching
        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        return "<div class ='previewContainer'>

                <img src='$thumbnail' class='previewImage' hidden>

                <video autoplay muted class='previewVideo' onended='previewEnded()'>
                    <source src='$preview' type='video/mp4'>
                </video>
                <div class='previewOverlay'>

                    <div class='mainDetails'>
                        <h3>$name</h3>
                        $subHeading
                        <div class='buttons'>
                            <button onclick='watchVideo($videoId)'><i class='far fa-play-circle'></i> $playButtonText </button>
                            <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                        </div>
                        
                    </div>

                </div/>

            </div>";
    }
    
    public function createEntityPreviewSquare($entity)
    {   
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title= '$name'>
                    </div>
                </a>";
    }

    private function getRandomEntity()
    {
        $entity = EntityProvider::getEntities($this->conn, null, 1);
        return $entity[0];
    }
}
?>