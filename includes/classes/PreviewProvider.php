<?php
class PreviewProvider
{
    private $conn, $username;
    public function __construct($conn, $username)
    {
        $this->con= $conn;
        $this->username= $username;
    }
    public function createPreviewVideo()
    {
        echo "hello";
    }
}
?>