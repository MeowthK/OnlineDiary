<?php

function UsernameExists($username, $connection)
{
    $query = "SELECT * FROM users WHERE UserID=?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $query))
    {
        return -1;
    }

    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    mysqli_stmt_close($statement);

    return mysqli_num_rows($result) > 0;
}