<?php

session_start();

if (!isset($_SESSION["current-user"]))
{
    header("location: index.php?errormsg=notloggedin");
    exit();
}

require_once "mysql-connection.php";

$userID = $_SESSION["current-user"];
$entry = $_POST["diary-entry"];

WriteDiaryEntry($entry, $userID, $connection);
