<?php

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

require_once "mysql-connection.php";

$query = "SELECT * FROM users WHERE UserID=?";

$statement = mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($statement, $query))
{
    echo "Something went wrong. :(";
    exit();
}

mysqli_stmt_bind_param($statement, "s", $username);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);
mysqli_stmt_close($statement);

if (UsernameExists($username, $connection))
{
    $row = mysqli_fetch_array($result);
    $UserID = $row["UserID"];
    $HashedPassword = $row["Password"];
    $UserName = $row["Name"];
    $AccountCreationDate = $row["AccountCreationDate"];

    if (password_verify($password, $HashedPassword))
    {
        $_SESSION["current-user"] = $UserID;
        $_SESSION["current-user-name"] = $UserName;
        header("location: home.php");
    }
    else
        header("location: index.php?errormsg=invalidcredentials");
}
else
    header("location: index.php?errormsg=usernamenotfound");
