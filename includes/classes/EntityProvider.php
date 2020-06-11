<?php
class EntityProvider
{
    public static function getEntities($conn, $categoryId, $limit)
    {
        $sql = "SELECT * FROM entities ";

        if($categoryId != null)
        {
            $sql .= "WHERE categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $conn->prepare($sql);

        if($categoryId != null)
        {
            $query->bindValue(":categoryId", $categoryId);
        }
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $result[] = new Entity($conn,$row);
        }

        return $result;

    }
}
?>