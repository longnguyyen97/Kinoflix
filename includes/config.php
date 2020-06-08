<?php
    ob_start(); //turn on output buffering (waits until all php code executed before outputting into page)
    session_start(); //saving variables and values even after page is close

    date_default_timezone_set("Asia/Ho_Chi_Minh");// set default timezone

    try
    {
        $conn = new PDO("mysql:dbname=kinoflix;host=localhost","root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (PDOException $e)
    {
        exit("Connection failed: " . $e-getMessage());
    }
?>