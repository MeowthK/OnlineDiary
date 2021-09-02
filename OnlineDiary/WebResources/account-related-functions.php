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

function GetDiaryEntry($userID, $date, $connection)
{
    $query = "SELECT DiaryID, UserID FROM diaryentries WHERE DateWritten=?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $query))
        return "!lookuperror";

    mysqli_stmt_bind_param($statement, "s", $date);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result))
    {
        if (password_verify($userID, $row["UserID"]))
        {
            $query = "SELECT Entry FROM diaryentries WHERE DiaryID=?";
            $diaryID = $row["DiaryID"];

            if (!mysqli_stmt_prepare($statement, $query))
                return "!lookuperror2";

            mysqli_stmt_bind_param($statement, "i", $diaryID);
            mysqli_stmt_execute($statement);

            $result = mysqli_stmt_get_result($statement);
            $row = mysqli_fetch_assoc($result);

            mysqli_stmt_close($statement);

            if (count($row) > 0)
                return array($diaryID, $row["Entry"]);

            break;
        }
    }

    return "!diarynotfound";
}

function DeleteDiaryEntry($DiaryID, $connection)
{
    $query = "DELETE FROM diaryentries WHERE DiaryID=?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $query))
    {
        header("location: home.php?error=lookuperror");
        exit();
    }

    mysqli_stmt_bind_param($statement, "i", $DiaryID);
    mysqli_stmt_execute($statement);

    if (mysqli_stmt_affected_rows($statement) > 0)
    {
        header("location: home.php?error=none");
        exit();
    }

    header("location: home.php?error=norecordsaffected");
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
            mysqli_stmt_close($statement);

            header("location: home.php?error=none");
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
    mysqli_stmt_close($statement);

    header("location: home.php?error=none");
    exit();
}
