<?php
class Entity
{   
    private $conn, $sqlData; /*$sqlData can be either data from database or entity ID
    it can be 2 things because i want it to create entity object using ID or using data from table
    so instead of create a new instance of this class by passing in an ID and it can get all the data fron
    the table for that entity, i have the data already called in PreViewProvider with $row so i just 
    can pass that in without having to go and get the data again*/
    
    public function __construct($conn, $input)
    {
        $this->conn = $conn;

        if(is_array($input))
        {
            $this->sqlData = $input;
        }
        else 
        {
            $query = $this->conn->prepare("SELECT * FROM entities WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId()
    {
        return $this->sqlData["id"];
    }
    
    public function getName()
    {
        return $this->sqlData["name"];
    }

    public function getThumbnail()
    {
        return $this->sqlData["thumbnail"];
    }

    public function getPreview()
    {
        return $this->sqlData["preview"];
    }
}
?>