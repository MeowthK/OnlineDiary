<?php
    session_start();
    
    require_once "mysql-connection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Diary</title>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <section>
            
            <?php

                if (!isset($_SESSION["current-user"]))
                {
                    header("location: index.php?errormsg=notloggedin");
                    exit();
                }

            ?>

            <form action="logout.php" method="POST">

                <?php

                    echo "Hello, " . $_SESSION["current-user-name"] . "!<br>";
                    echo "Diary Entry Date: " . date("m/d/Y") . "<hr>";

                ?>

                <button type="submit" name="submit">Log out</button>
                <br>
                <br>
            </form>
            
            <form action="diary-entry.php" method="POST">
                <textarea class="textarea-resize-lock" name="diary-entry" id="diary-entry" rows="25" cols="100" placeholder="How was your day?" required><?php
                    
                    $entry = GetDiaryEntry($_SESSION["current-user"], date("Y-m-d"), $connection);

                    if (is_array($entry) && count($entry) >= 2)
                    {
                        $_SESSION["current-entry-id"] = $entry[0];
                        echo $entry[1];
                    }
                    else
                        $_SESSION["current-entry-id"] = null;

                ?></textarea>
                <br>
                <div>

                    <?php

                        if (isset($_GET["error"]))
                        {
                            $errorList = [ "none" => "No errors.",
                                           "lookuperror" => "Placeholder X",
                                           "lookuperror2" => "Placeholder Y",
                                           "insertionerror" => "Can't record current entry :(" ];

                            echo "Error log: " . $errorList[$_GET["error"]];
                        }

                    ?>

                </div>
                <br>

                <?php
                    $dateInput = "<input type='date' name='diary-date' id='diary-date'";
                    $currentDate = date("Y-m-d");
                    $dateInput .= "value='$currentDate' max='$currentDate'/>";

                    echo $dateInput;
                ?>
                <button type="submit" class="hidden2" name="delete" id="delete">Crumple</button>
                <button type="submit" name="submit" id="submit">Write to Diary</button>
            </form>
        </section>
        <script src="js/script.js"></script>
    </body>
</html>
