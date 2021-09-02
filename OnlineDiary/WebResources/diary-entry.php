<?php

session_start();

require_once "mysql-connection.php";

if (!isset($_SESSION["current-user"]))
{
    header("location: index.php?errormsg=notloggedin");
    exit();
}

$userID = $_SESSION["current-user"];

if (isset($_POST["delete"]) && $_SESSION["current-entry-id"] != null)
{
    DeleteDiaryEntry($_SESSION["current-entry-id"], $connection);
    exit();
}

$entry = $_POST["diary-entry"];

WriteDiaryEntry($entry, $userID, $connection);
