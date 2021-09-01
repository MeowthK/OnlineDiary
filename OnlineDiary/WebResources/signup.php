<?php

session_start();

if (isset($_SESSION["current-user"]))
{
    header("location: home.php");
    exit();
}

$name = $_POST["name"];
$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

if ($password != $password2)
{
    header("location: index.php?signup-error=passwordmismatch");
    exit();
}

require_once "mysql-connection.php";

if (UsernameExists($username, $connection))
{
    header("location: index.php?signup-error=usernameexists");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users(UserID, Password, Name)
            VALUES(?, ?, ?)";

$statement = mysqli_stmt_init($connection);

if (!mysqli_stmt_prepare($statement, $query))
{
    echo "Something went wrong. :(";
    exit();
}

mysqli_stmt_bind_param($statement, "sss", $username, $hashedPassword, $name);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
mysqli_stmt_close($statement);

if ($result === false)
    header("location: signup-success.php");
else
    echo "Something went wrong. Please try again.";
