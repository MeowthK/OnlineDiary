<?php

session_start();

require_once("mysql-connection.php");

if (isset($_GET["entrydate"]))
{
    $userID = $_SESSION["current-user"];
    $dateWritten = $_GET["entrydate"];

    WriteDiaryEntryToHTML($userID, $dateWritten, $connection);
}
