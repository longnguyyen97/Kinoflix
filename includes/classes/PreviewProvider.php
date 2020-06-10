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
        
        return "<div class ='previewContainer'>

                <img src='$thumbnail' class='previewImage' hidden>

                <video autoplay muted class='previewVideo'>
                    <source src='$preview' type='video/mp4'>
                </video?

            </div>";

    }

    private function getRandomEntity()
    {
        $query = $this->conn->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        return new Entity($this->conn, $row);
    }
}
?>