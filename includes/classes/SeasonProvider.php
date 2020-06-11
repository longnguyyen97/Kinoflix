<?php
class SeasonProvider
{
    public function __construct($conn, $username)
    {
        $this->conn= $conn;
        $this->username = $username;
    }

    public function create($entity)
    {
        $seasons = $entity->getSeasons();

        if(sizeof($seasons) == 0)
        {
            return;
        }
        $seasonHtml = "";
        foreach($seasons as $season)
        {
            $seasonNumber = $season->getSeasonNumber();
            
            $videosHtml="";
            foreach($season->getVideos() as $video)
            {
                $videosHtml .= $this->createVideoSquare($video);
            }

            $seasonHtml .= "<div class='season'>
                            <h3>Season $seasonNumber</h3>
                            <div class='video'>
                                $videosHtml
                            </div>
                            </div>";
        }

        return $seasonHtml;
    }

    private function createVideoSquare($video)
    {
        $id = $video->getId();
        $thumbnail = $video->getThumbnail();
        $name = $video->getTitle();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();

        return "<a href='watch.php?id=$id'>
                    <div class='episodeContainer'>
                        <div class='contents'>
                            <img src='$thumbnail'>
                            <div class='videoInfo'>
                                <h4>$episodeNumber. $name</h4>

                                <span>$description</span>
                            </div>
                        </div>
                    </div>
                </a>";
    }
}
?>