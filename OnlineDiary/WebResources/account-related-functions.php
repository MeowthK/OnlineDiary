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

function WriteDiaryEntry($entry, $userID, $connection)
{
    $currentDate = date("Y-m-d");
    $query = "SELECT DiaryID, UserID FROM diaryentries WHERE DateWritten=?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $query))
    {
        header("location: home.php?error=lookuperror");
        exit();
    }

    mysqli_stmt_bind_param($statement, "s", $currentDate);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result))
    {
        if (password_verify($userID, $row["UserID"]))
        {
            $query = "UPDATE diaryentries SET Entry=? WHERE DiaryID=?";
            $diaryID = $row["DiaryID"];

            if (!mysqli_stmt_prepare($statement, $query))
            {
                header("location: home.php?error=lookuperror2");
                exit();
            }

            mysqli_stmt_bind_param($statement, "si", $entry, $diaryID);
            mysqli_stmt_execute($statement);

            if (mysqli_stmt_affected_rows($statement) > 0)
            {
                header("location: home.php?error=none&lastentry=$entry");
                mysqli_stmt_close($statement);
            }

            exit();
        }
    }

    $query = "INSERT INTO diaryentries(UserID, Entry, DateWritten) VALUES(?, ?, ?)";

    if (!mysqli_stmt_prepare($statement, $query))
    {
        header("location: home.php?error=insertionerror");
        exit();
    }

    $hashedUserID = password_hash($userID, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($statement, "sss", $hashedUserID, $entry, $currentDate);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0)
    {
        header("location: home.php?error=none&lastentry=$entry");
        mysqli_stmt_close($statement);
    }

    exit();
}
