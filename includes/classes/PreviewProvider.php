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

        //TODO: ADD SUBTITLE
        
        return "<div class ='previewContainer'>

                <img src='$thumbnail' class='previewImage' hidden>

                <video autoplay muted class='previewVideo' onended='previewEnded()'>
                    <source src='$preview' type='video/mp4'>
                </video>
                <div class='previewOverlay'>

                    <div class='mainDetails'>
                        <h3>$name</h3>

                        <div class='buttons'>
                            <button><i class='far fa-play-circle'></i> Play</button>
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