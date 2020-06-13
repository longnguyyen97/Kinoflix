<?php
class Video 
{
    private $conn, $sqlData, $entity;

    public function __construct($conn, $input) 
    {
        $this->conn = $conn;

        if(is_array($input)) 
        {
            $this->sqlData = $input;
        }
        else 
        {
            $query = $this->conn->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->entity = new Entity($conn, $this->sqlData["entityId"]);
    }

    public function getId() 
    {
        return $this->sqlData["id"];
    }

    public function getTitle() 
    {
        return $this->sqlData["title"];
    }

    public function getDescription() 
    {
        return $this->sqlData["description"];
    }

    public function getFilePath() 
    {
        return $this->sqlData["filePath"];
    }

    public function getThumbnail() 
    {
        return $this->entity->getThumbnail();
    }

    public function getEpisodeNumber() 
    {
        return $this->sqlData["episode"];
    }

    public function getSeasonNumber() 
    {
        return $this->sqlData["season"];
    }

    public function getEntityId() 
    {
        return $this->sqlData["entityId"];
    }


    public function incrementViews() 
    {
        $query = $this->conn->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindValue(":id", $this->getId());
        $query->execute();
    }

    public function isMovie()
    {
        //check if this video is a movie or not
        return $this->sqlData["isMovie"] == 1;
    }

    public function getSeasonAndEpisode()
    {
        
        if($this->isMovie())
        {
            return;
        }
        //if not a movie, get the season and ep number
        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        return "Season $season, Episode $episode";
    }

    public function isInProgress($username)
    {
        $query = $this->conn->prepare("SELECT * FROM videoProgress 
                                    WHERE videoId=:videoId AND username=:username");
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username",$username);
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function hasSeen($username)
    {
        $query = $this->conn->prepare("SELECT * FROM videoProgress 
                                    WHERE videoId=:videoId AND username=:username AND finished=1");
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username",$username);
        $query->execute();

        return $query->rowCount() != 0;
    }
}
?>