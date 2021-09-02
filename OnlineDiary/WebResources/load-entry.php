<?php

session_start();

require_once("mysql-connection.php");

if (isset($_GET["entrydate"]))
{
    $userID = $_SESSION["current-user"];
    $dateWritten = $_GET["entrydate"];

    $entry = GetDiaryEntry($userID, $dateWritten, $connection);
    
    if (is_array($entry) && count($entry) >= 2)
    {
        $_SESSION["current-entry-id"] = $entry[0];
        echo $entry[1];
    }
    else
        $_SESSION["current-entry-id"] = null;
}
