<?php
class VideoProvider
{
    public static function getUpNext($conn, $currentVideo) 
    {
        $query = $conn->prepare("SELECT * FROM videos WHERE entityId=:entityId
                                 AND id != :videoId AND 
                                 (
                                    (season = :season AND episode > :episode) OR season > :season
                                 ) ORDER BY season, episode ASC LIMIT 1");
                                  /*select all from videos table beside the video that are curently watching
                                    , after that get the video from the SAME season BUT episode number IS BIGGER
                                    than the current one. If there are no episode, GET THE NEXT SEASON
                                    ORDER the data ascending by 1*/
        $query->bindValue(":entityId", $currentVideo->getEntityId());
        $query->bindValue(":season", $currentVideo->getSeasonNumber());
        $query->bindValue(":episode", $currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId", $currentVideo->getId());

        $query->execute();

        if($query->rowCount() == 0)
        {
            $query = $conn->prepare("SELECT * FROM videos
                                     WHERE season <= 1 AND episode <=1
                                     AND id != :videoId
                                     ORDER BY views DESC LIMIT 1");
                                     /*select the first episode of the first season, if season <1
                                     select a video different than the current video with highest view
                                     counts*/
            $query->bindValue(":videoId", $currentVideo->getId());
            $query->execute();
        }

        $row= $query->fetch(PDO::FETCH_ASSOC);
        return new Video($conn, $row);

    }
}
?>